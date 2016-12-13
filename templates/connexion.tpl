    
{if isset($error)}
    <div class='alert alert-error alert-dismissible' role='alert'>
        <strong> And you failed ! </strong>
    </div>
{/if}

<!-- Formulaire HTML de connexion -->
<div class="span8">
            
            <!-- FORMULAIRE -->
            <form action="connexion.php" method="POST" enctype="multipart/form-data" id="form_connexion" name="form_connexion">
                <div class="clearfix">
                        <label for="email">Email</label>
                        <div class="input"><input type="texte" placeholder="example@gmail.com" name="email" id="email" value=""> </div>
                </div>
     
                <div class="clearfix">
                        <label for="mdp">Mot de passe</label>
                        <div class="input"><input type="password" name="mdp" id="mdp"> </div>
                </div>

                <div class="form-actions">
                    <input type="submit" name="connexion" value="Connexion" class="btn btn-large btn-primary"> 
                </div>
            </form>

    </div>