<nav class="span4">
    <h3>Menu</h3>
    <form action='recherche.php' id='form_recherche'>
        <div class='clearfix'>
            <div class='input'><input type='text' name='recherche' id='recherche' placeholder='Votre recherche ...' /> </div>
            <div class='form-inline'><input type='submit' name='' value="rechercher" class="btn btn-mini btn-primary" /> </div>
        </div>
    </form>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <?php
        if ($connect == true) {
            ?>
            <li><a href="article.php">Rédiger un article</a></li>
            <li><a href="deconnexion.php">Déconnexion</a></li>

            <?php
        } else {
            ?>
            <li><a href="connexion.php">Connexion</a></li>
            <?php
        }
        ?>

    </ul>

</nav>
</div>