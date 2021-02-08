<header >
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
        <div class="container-fluid">
            <a class=" btn btn-secondary" href="./index">Startseite</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav" style="margin-left: auto!important;">
                    <?php if(isset($_SESSION["poll_admin"])): ?>
                    <li class="">
                        <a class=" btn btn-danger" href="./poll_admin">Admin</a>
                    </li>
                    <?php else: ?>
                        <li class="">
                            <a class=" btn btn-danger" href="./poll_admin">Anmelden</a>
                        </li>
                    <?php endif; ?>
                    <li class="">
                        <a class="btn btn-primary" href="./impressum">Impressum</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="title d-flex align-items-center justify-content-center">
        <?php if(isset($poll)): ?>
        <div class="title-wrapper text-center"><h1><?php echo $poll['title']; ?></h1>
            <p >Erstellt mit <b>SmartPoll</b></p>
    </div>
        <?php else: ?>
            <div class="title-wrapper text-center"><h1>SmartPoll</h1>
            </div>
        <?php endif; ?>
</header>