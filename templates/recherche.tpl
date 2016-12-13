        
<div class="span8">
    <!-- notifications -->
    {if isset($nombreArticlesAuTotal)}
        <div class='alert alert-success alert-dismissible' role='alert'>
            <strong>Il y a {$nombreArticlesAuTotal} résultat(s) pour votre recherche</strong>
        </div>
    {/if}
    <!-- contenu html -->
    
    {foreach from=$tab_recherches item=value} {*pour chaque resultat de la requete dans le tableau $tab_articles, on affiche les informations de l'article*}
            <h2>{$value['titre']}</h2>
            <img src="img/{$value['id']}.jpg" width="400px" alt="{$value['id']}"/>
            <p style="text-align: justify;">{$value['texte']}</p>
            <p><em><u>Publié le : {$value['date_fr']} </u></em></p> 
            {*{if $connect == 1}
                <a href="article.php?id={$value['id']}" > Modifier </a>
            {else}
            {/if} *}
    {/foreach}
        
    
    
    <div class="pagination"> {* fonction pour la pagination des articles *}
        <ul>
            <li><a>Page : </a></li>
            {for $foo=1 to $nbPages}
                {if $foo != $pageCourante}
                    <li><a href='recherche.php?recherche={$recherche}&p={$foo}'> {$foo}</a></li>
                {else}
                    <li class='active'><a href='recherche.php?p={$foo}'> {$foo}</a></li> 
                {/if}
            {/for}
        </ul>
    </div>
</div>