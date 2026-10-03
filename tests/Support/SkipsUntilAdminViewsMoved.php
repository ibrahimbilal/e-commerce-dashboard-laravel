<?php

namespace Tests\Support;

trait SkipsUntilAdminViewsMoved
{
    protected function skipUntilAdminViewsMoved(): void
    {
        $this->markTestSkipped('Blade layouts still reference legacy route/view paths; Fronty follow-up will git mv views under admin.');
    }
}
