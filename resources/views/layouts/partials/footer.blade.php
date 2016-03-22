
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        v{{ config('app.version_number') }} [{{ config('app.version_date') }}] Copyright &copy; 2016 <strong><a href="#">Fagan</a>.</strong>
    </div>
    <!-- Default to the left -->
    @yield('botoes-footer')
</footer>