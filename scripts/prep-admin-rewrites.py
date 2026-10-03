#!/usr/bin/env python3
"""Prep rewrites for Ibrahim admin merge (local only)."""
from __future__ import annotations

import re
from pathlib import Path

ROOT = Path('/workspace')
VIEW_ROOT = ROOT / 'resources/views'

# Branch storefront route prefixes -> admin.* (Backy will register these)
ROUTE_PREFIXES = [
    'marketing.subscribers',
    'marketing',
    'analytics.overview',
    'analytics',
    'order-statuses',
    'customers.addresses',
    'customers',
    'products',
    'categories',
    'attributes',
    'tags',
    'coupons',
    'discounts',
    'orders',
    'reviews',
    'invoices',
    'dashboard',
    'settings',
    'languages',
    'gallery',
    'profile',
    'two-factor.recovery',
]

# Ibrahim main names that stay until Backy renames (do not prefix admin.)
SKIP_ROUTE_NAMES = {
    'admin.index',
    'login',
    'password.request',
    'password.reset',
    'verification.notice',
    'two-factor.login',
    'users.profile',
    'users.update_profile',
    'users.logout_sessions',
    'users.show_recovery_code',
    'users.regenerate_recovery_code',
    'users.restore',
    'users.force_delete',
    'users.bulk_delete',
    'users.bulk_restore',
    'users.bulk_force_delete',
    'users.index',
    'users.create',
    'users.edit',
    'users.show',
    'users.update',
    'users.destroy',
    'roles.index',
    'roles.create',
    'roles.edit',
    'roles.show',
    'roles.store',
    'roles.update',
    'roles.destroy',
    'gallery.index',
    'gallery.create',
    'gallery.store',
    'gallery.show',
    'gallery.edit',
    'gallery.update',
    'gallery.destroy',
    'get_metas',
    'langs.index',
    'langs.create',
    'langs.store',
    'langs.edit',
    'langs.update',
    'langs.destroy',
    'date_preview',
    'multi_currencies',
    'recipients_type',
    'index',
    'errors.400',
    'errors.401',
    'errors.403',
    'errors.404',
    'errors.500',
    'errors.503',
}

MOVED_SECTIONS = {
    'products', 'categories', 'tags', 'attributes', 'orders', 'order-statuses',
    'customers', 'coupons', 'discounts', 'reviews', 'invoices', 'marketing',
    'analytics', 'dashboard',
}


def should_rewrite_view(path: Path) -> bool:
    rel = path.relative_to(VIEW_ROOT)
    parts = rel.parts
    if parts[0] == 'components':
        return True
    if parts[0] == 'admin' and parts[1] in MOVED_SECTIONS:
        return True
    if parts[0] == 'admin' and parts[1] == 'layouts':
        return True
    return False


def rewrite_routes(content: str) -> str:
    def repl(match: re.Match) -> str:
        quote = match.group(1)
        name = match.group(2)
        if name in SKIP_ROUTE_NAMES or name.startswith('admin.'):
            return match.group(0)
        for prefix in sorted(ROUTE_PREFIXES, key=len, reverse=True):
            if name == prefix or name.startswith(prefix + '.'):
                new_name = 'admin.' + name
                return f"route({quote}{new_name}{quote}"
        return match.group(0)

    return re.sub(r"route\((['\"])([^'\"]+)\1", repl, content)


def rewrite_paths(content: str) -> str:
    content = content.replace("@extends('layouts.app')", "@extends('admin.layout')")
    content = content.replace('@extends("layouts.app")', '@extends("admin.layout")')
    content = content.replace("@extends('layouts.auth')", "@extends('admin.auth-layout')")
    content = content.replace('@extends("layouts.auth")', '@extends("admin.auth-layout")')
    content = content.replace("layouts.partials.", "admin.layouts.partials.")
    content = content.replace("@include('layouts.", "@include('admin.layouts.")
    content = content.replace('@include("layouts.', '@include("admin.layouts.')
    return content


def rewrite_controller_views(content: str) -> str:
    return re.sub(
        r"view\('([a-z0-9_-]+(?:\.[a-z0-9_-]+)+)'",
        lambda m: f"view('admin.{m.group(1)}'" if m.group(1).split('.')[0] in MOVED_SECTIONS | {'settings', 'languages', 'gallery', 'profile', 'auth'} else m.group(0),
        content,
    )


def main() -> None:
    for path in VIEW_ROOT.rglob('*.blade.php'):
        if not should_rewrite_view(path):
            continue
        text = path.read_text()
        new = rewrite_paths(rewrite_routes(text))
        if new != text:
            path.write_text(new)

    ctrl_dir = ROOT / 'app/Http/Controllers'
    for path in ctrl_dir.rglob('*.php'):
        if path.parts[-2] == 'Admin':
            continue
        text = path.read_text()
        new = rewrite_controller_views(text)
        if new != text:
            path.write_text(new)

    # ProfileController -> admin.users.profile view? profile deleted; map separately
    pc = ctrl_dir / 'ProfileController.php'
    if pc.exists():
        t = pc.read_text()
        t2 = t.replace("view('profile.edit'", "view('admin.users.profile'")
        if t2 != t:
            pc.write_text(t2)


if __name__ == '__main__':
    main()
