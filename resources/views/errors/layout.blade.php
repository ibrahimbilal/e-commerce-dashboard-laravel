<!DOCTYPE html>
<html dir="ltr" lang="en">
	<head>
		<!-- Meta Tags-->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<!-- Fonts-->

		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&amp;display=swap" rel="stylesheet">
		<title>{{ config('app.name') }} | @yield('title', 'Admin Panel')</title>

		<!-- Page Css -->
		<style>
			html {
				--main-color: #2C2CCC;
				--main-color-hover: #2323a2;
				--body-background: #F5F5F5;
				--text-color: #333;
				--box-bg-color: #FFF;
				--box-shadow-color: #E4E4E4;
				--menu-active-bg: #F3F3FF;
				--menu-active-border-color: var(--main-color);
				--menu-badge-bg: #FF9F43;
				--line-color: var(--body-background);
				--scroll-bar-bg: var(--box-bg-color);
				--scroll-bar-color: #CCC;
				--success-color: #28C76F;
				--danger-color: #EA5455;
				--warning-color: #FF9F43;
				--border-color: #ced4da;
				--disable-text-color: #707070;
			}

			html.dark {
				--main-color: #675ad0;
				--main-color-hover: #877be6;
				--body-background: #121212;
				--box-bg-color: #1D1D1D;
				--text-color: #E1E1E1;
				--box-shadow-color: #0a0a0a;
				--menu-active-bg: #3c3c3c;
				--scroll-bar-bg: var(--box-bg-color);
				--scroll-bar-color: #000;
				--border-color: #707070;
			}

			::selection {
				color: #FFF;
				background-color: var(--main-color);
			}

			::-moz-selection {
				color: #FFF;
				background-color: var(--main-color);
			}

			* {
				outline: none;
			}

			html {
				overflow-x: hidden;
				scrollbar-color: var(--scroll-bar-color) var(--scroll-bar-bg);
				scrollbar-width: thin;
			}

			html::-webkit-scrollbar-track {
				background-color: var(--scroll-bar-bg);
				border-radius: 10px;
			}

			html::-webkit-scrollbar {
				width: 10px;
				height: 10px;
				background-color: var(--scroll-bar-bg);
			}

			html::-webkit-scrollbar-thumb {
				border-radius: 10px;
				background-color: var(--scroll-bar-color);
				border: 2px solid var(--scroll-bar-bg);
			}

			body {
				font-family: 'Montserrat', sans-serif;
				background-color: var(--body-background);
				color: var(--text-color);
				height: 100vh;
				margin: 0;
			}

			.error-wrapper {
				width: 100%;
				height: 100%;
				display: -webkit-box;
				display: -webkit-flex;
				display: -moz-box;
				display: -ms-flexbox;
				display: flex;
				justify-content: center;
				align-items: center;
				flex-direction: column;
				text-align: center;
				position: relative;
			}

			.error-wrapper .error-code {
				position: absolute;
				color: var(--box-bg-color);
				z-index: -1;
				font-size: 12rem;
			}

			@media screen and (min-width: 576px) {
				.error-wrapper .error-code {
					font-size: 20rem;
				}
			}

			.error-wrapper .error-content p {
				margin: 0 0 5px;
				text-transform: capitalize;
				font-size: 1rem;
			}

			@media screen and (min-width: 576px) {
				.error-wrapper .error-content p {
					font-size: 1.4rem;
				}
			}

			.error-wrapper .error-cta {
				margin-top: 1rem;
			}

			.error-wrapper .error-cta a {
				display: inline-block;
				font-weight: 400;
				line-height: 1.5;
				text-decoration: none;
				min-width: 130px;
				text-transform: capitalize;
				border-radius: 5px;
				background-color: var(--main-color);
				color: #FFF;
				font-size: 0.8rem;
				padding: 0.375rem 0.75rem;
			}

			@media screen and (min-width: 576px) {
				.error-wrapper .error-cta a {
					font-size: 1rem;
				}
			}

			.error-wrapper .error-cta a:hover {
				background-color: var(--main-color-hover);
				border-color: var(--main-color-hover);
				color: #FFF;
				box-shadow: 2px 2px 6px 0 var(--main-color);
			}
		</style>
		<!-- async scripts-->
		<script type="text/javascript" async>
			// Active Dark Mode On Load Page
			if (localStorage.getItem("theme_mode") != null) {
				document.documentElement.classList.add("dark");
			}
		</script>
	</head>

	<body class="body-class">
		<div class="error-wrapper">
			@yield('content')
		</div>
	</body>

</html>
