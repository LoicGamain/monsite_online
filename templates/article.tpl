<div class="span8">
    <!-- NOTIFICATION -->

    {if isset($notification_ajout)}
        <div class='alert alert-success alert-dismissible' role='alert'>
            <strong>Félicitations!</strong> Votre article a bien été ajouté.
        </div>
    {/if}
    
    {if isset($notification_modif)}
        <div class='alert alert-success alert-dismissible' role='alert'>
            <strong>Félicitations!</strong> Votre article a bien été modifié.
        </div>
    {/if}
    
        
        <!-- FORMULAIRE -->
    <form action="article.php" method="post" enctype="multipart/form-data" id="form_articles" name="form_article">
            
        <div class="clearfix">
            <label for="titre">Titre</label>
            <div class="input"><input type="texte" name="titre" id="titre" value="{$tab_articles[$verifIdExistant-1]['titre']}"> </div>
        </div>
 
        <div class="clearfix">
            <label for="titre">Texte</label>
            <div class="input"><textarea type="texte" name="texte" id="texte" >{$tab_articles[$verifIdExistant-1]['texte']}</textarea> </div>
        </div>

        <div class="clearfix">
            <label for="image">Image</label>
            <div class="input"><input type="file" name="image" id="image" > </div>
        </div>

        <div class="clearfix">
            <label for="publie">Publié</label>
            <div class="input"><input type="checkbox" {$publieArticle} name="publie" id="publie" value=""> </div>  
        </div>

        <div class="form-actions">
            <input type="submit" name="{$boutonValidation}" value="{$boutonValidation}" class="btn btn-large btn-primary"> 
        </div>
  
        <div class="clearfix">
            <div class="input"><input type="hidden" name="id" id="id" value="{$verifIdExistant}"> </div>
        </div>
    </form>

</div>