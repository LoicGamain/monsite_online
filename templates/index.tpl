<div class="span8">
    
    <!-- notifications -->
    {if isset($refuser)}
        <div class='alert alert-error alert-dismissible' role='alert'>
            <strong>Veuillez vous connectez pour accèder à cette page ! </strong>
        </div>
    {/if}
    
    {if isset($deconnect)}
        <div class='alert alert-success alert-dismissible' role='alert'>
            <strong>Vous êtes bien déconnecté ! </strong>
        </div>
    {/if}
    
    {if isset($id)}
        <div class='alert alert-success alert-dismissible' role='alert'>
            <strong>Bienvenue ! </strong>
        </div>
    {/if}
    
    {if isset($supprimer)}
        <div class='alert alert-success alert-dismissible' role='alert'>
            <strong>L'article a bien été supprimé ! </strong>
        </div>
    {/if}
    
    
    {if isset($commentaire)} 
        <!-- code html pour afficher les commentaires d'un article -->
           <!-- FORMULAIRE -->
      
        
    {else}
        <!-- contenu html pour l'affichage de la page accueil avec les différents articles -->
        {foreach from=$tab_articles item=value} {*pour chaque resultat de la requete dans le tableau $tab_articles, on affiche les informations de l'article*}
                <h2>{$value['titre']}</h2>
                <img src="img/{$value['id']}.jpg" width="400px" alt="{$value['id']}"/>
                <p style="text-align: justify;">{$value['texte']}</p>
                <p><em><u>Publié le : {$value['date_fr']} </u></em></p> 
                {if $connect == 1}
                    <a href="article.php?id={$value['id']}" > Modifier </a>
                    <a href="supprimer.php?id={$value['id']}" > Supprimer </a>
                    <a href="index.php?commentaire={$value['id']}" > Commentaire </a>
                {else}
                {/if}
        {/foreach}

        
        {* fonction pour la pagination des articles *}
        <div class="pagination"> 
            <ul>
                <li><a>Page : </a></li>
                {for $foo=1 to $nbPages}
                    {if $foo != $pageCourante}
                        <li><a href='index.php?p={$foo}'> {$foo}</a></li>
                    {else}
                        <li class='active'><a href='index.php?p={$foo}'> {$foo}</a></li> 
                    {/if}
                {/for}
            </ul>
        </div>
        
    {/if}
    
</div>