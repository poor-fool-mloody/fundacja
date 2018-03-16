<nav class="navbar navbar-expand-lg navbar-light bg-light">
<!--    <a class="navbar-brand" href="#">Navbar</a>-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url().'index.php/admin/'; ?>">Wszystkie produkty</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url().'index.php/admin/addProduct'; ?>">Dodaj produkt</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url().'index.php/photos/resetphoto'; ?>">Ustaw początkowe zdjęcie</a>
            </li>			
        </ul>
        <ul class="nav navbar-nav ml-auto justify-content-end">
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Aktualne zdjęcie: <?php echo $photo == null ? "0" : $photo; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Kwota zebrana: <?php echo $amount/100; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url().'index.php/admin/logout'; ?>">Wyloguj</a>
            </li>
        </ul>
    </div>
</nav>