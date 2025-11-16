<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>@yield('title', 'MyApp')</title>
<link href="https://fonts.bunny.net/css?family=Inter:100,200,300,400,500,600" rel="stylesheet">
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
<style>
:root{--bg:#ffffff;--muted:#9aa0a6;--text:#0b0b0b;--accent:#000000;--glass:rgba(255,255,255,0.75)}
html,body{height:100%;margin:0;background:var(--bg);color:var(--text);font-family:'Inter',system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;font-weight:300;text-decoration:none}
.pill-nav-wrap{position:fixed;top:18px;left:50%;transform:translateX(-50%);z-index:1200;padding:6px 30px;border-radius:9999px;background:linear-gradient(180deg,rgba(255,255,255,0.95),rgba(250,250,250,0.95));box-shadow:0 10px 30px rgba(8,10,12,0.10),0 1px 0 rgba(0,0,0,0.02) inset;backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);border:1px solid rgba(10,10,10,0.06);max-width:calc(100% - 48px)}
.pill-nav{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:6px 12px;border-radius:9999px;width:100%}
.pill-brand{display:inline-flex;align-items:center;gap:8px;padding:6px 10px;border-radius:9999px;font-weight:500;font-size:0.95rem;color:var(--accent);white-space:nowrap;text-decoration:none}
.pill-links{display:flex;gap:8px;align-items:center;overflow:auto;-webkit-overflow-scrolling:touch;scrollbar-width:none;max-width:calc(100%)}
.pill-links::-webkit-scrollbar{display:none}
.pill-links a{display:inline-flex;align-items:center;padding:6px 10px;border-radius:9999px;text-decoration:none;font-size:0.85rem;font-weight:500;color:var(--accent);transition:all .18s cubic-bezier(.2,.9,.2,1);white-space:nowrap;border:1px solid transparent;background:transparent}
.pill-links a:hover{background:var(--accent);color:#fff;transform:translateY(-1px);box-shadow:0 6px 18px rgba(0,0,0,0.12)}
.pill-dropdown{position:relative;margin-left:8px}
.pill-dropdown-toggle{cursor:pointer;display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border-radius:9999px;font-weight:500;background:transparent;border:none;color:var(--accent);font-size:0.88rem}
.pill-dropdown-toggle:focus{outline:2px solid rgba(0,0,0,0.06);outline-offset:2px}
.pill-dropdown-menu{display:none;position:absolute;top:calc(100% + 10px);right:0;background:#fff;border-radius:12px;padding:6px;min-width:180px;box-shadow:0 14px 40px rgba(8,10,12,0.12);border:1px solid rgba(10,10,10,0.06);z-index:1400}
.pill-dropdown-menu.show{display:block}
.pill-dropdown-menu a{display:block;padding:8px 12px;color:var(--text);text-decoration:none;border-radius:8px;font-size:0.9rem}
.pill-dropdown-menu a:hover{background:#f6f6f6}
main{padding-top:92px}
.container{max-width:1200px;margin:0 auto;padding:0 20px}
.alert{padding:12px 16px;border-radius:12px;margin-bottom:18px;font-size:0.95rem;text-align:center}
.alert-success{background:#0b6623;color:#fff;border:1px solid rgba(0,0,0,0.06)}
@media (max-width:640px){.pill-nav-wrap{top:12px;padding:4px}.pill-brand{padding:6px 8px;font-size:.9rem}.pill-links a{padding:6px 8px;font-size:.82rem}main{padding-top:86px}}
.dashboard{max-width:1200px;margin:0 auto;padding:2.5rem 1.5rem}
.dash-title{font-size:2rem;font-weight:300;margin-bottom:0.2rem;letter-spacing:-0.5px}
.dash-sub{font-size:1rem;color:#555;margin-bottom:2rem}
.dash-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:1.5rem}
.dash-card{display:flex;flex-direction:column;align-items:flex-start;padding:1.4rem 1.6rem;border:1px solid #e5e5e5;border-radius:18px;text-decoration:none;background:#fff;transition:all .25s ease;color:black}
.dash-card:hover{border-color:#000;box-shadow:0 8px 28px rgba(0,0,0,0.07);transform:translateY(-3px)}
</style>
</head>
<body>
<div id="app">
<div class="pill-nav-wrap" role="navigation" aria-label="Primary">
<div class="pill-nav container">
<a class="pill-brand" href="{{ route('home') }}"><span>Library</span></a>
<div class="pill-links" role="menu" aria-label="Primary Links">
@guest
@if (Route::has('login'))
<a href="{{ route('login') }}" role="menuitem">Login</a>
@endif
@if (Route::has('register'))
<a href="{{ route('register') }}" role="menuitem">Register</a>
@endif
@else
@canany(['create-role', 'edit-role', 'delete-role'])
<a href="{{ route('roles.index') }}" role="menuitem">Roles</a>
@endcanany
@canany(['create-user', 'edit-user', 'delete-user'])
<a href="{{ route('users.index') }}" role="menuitem">Users</a>
@endcanany
@can('view-books')
<a href="{{ route('books.index') }}" role="menuitem">Books</a>
@endcan
@endguest
</div>
@auth
<div class="pill-dropdown" aria-haspopup="true">
<button class="pill-dropdown-toggle" id="pillDropdownToggle" aria-expanded="false" aria-controls="pillDropdownMenu">
{{ Auth::user()->name }}
<svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden>
<path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</button>
<div class="pill-dropdown-menu" id="pillDropdownMenu" role="menu" aria-labelledby="pillDropdownToggle">
<a href="{{ route('logout') }}" role="menuitem" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
</div>
</div>
@endauth
</div>
</div>
<main>
<div class="container">
@if ($message = Session::get('success'))
<div class="alert alert-success">{{ $message }}</div>
@endif
@yield('content')
</div>
</main>
</div>
<script>
(function(){document.addEventListener('DOMContentLoaded',()=>{const toggle=document.getElementById('pillDropdownToggle');const menu=document.getElementById('pillDropdownMenu');if(!toggle||!menu)return;const closeMenu=()=>{menu.classList.remove('show');toggle.setAttribute('aria-expanded','false')};const openMenu=()=>{menu.classList.add('show');toggle.setAttribute('aria-expanded','true')};toggle.addEventListener('click',(e)=>{e.stopPropagation();if(menu.classList.contains('show'))closeMenu();else openMenu()});document.addEventListener('click',(e)=>{if(!menu.contains(e.target)&&!toggle.contains(e.target)){closeMenu()}});document.addEventListener('keydown',(e)=>{if(e.key==='Escape')closeMenu();if(e.key==='ArrowDown'&&document.activeElement===toggle){e.preventDefault();openMenu();const first=menu.querySelector('[role="menuitem"]');if(first)first.focus()}})})})();
</script>
</body>
</html>