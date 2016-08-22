
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- search form (Optional) -->
        <form action="/pesquisa" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Busca...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">CONTÁBIL</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="/contas"><i class="fa fa-book"></i> <span>Contas</span></a></li>
            <li><a href="/lancamentos_futuros"><i class="fa fa-calendar-check-o"></i> <span>Contas a Pagar</span></a>
            </li>
            <li><a href="/favorecidos"><i class="fa fa-user"></i> <span>Favorecidos</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-pie-chart"></i> <span>Relatórios</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="/balanco_patrimonial">Balanço Patrimonial</a></li>
                    <li><a href="/resultado">Resultado</a></li>
                </ul>
            </li>
            <li class="header">PAGAMENTO</li>
            <li class="header">VENDAS</li>
            <li class="header">AGRO</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="/frutas"><i class="fa fa-apple"></i> <span>Frutas</span></a></li>
            <li class="active"><a href="/variedades_fruta"><i class="fa fa-apple"></i> <span>Variedades Fruta</span></a>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
