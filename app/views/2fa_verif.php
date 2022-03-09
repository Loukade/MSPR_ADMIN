<div class="container">
    <div class="row">
        <form class="col s12" method="post" id="logForm">
            <div class="row">
                <div class="input-field col s12">
                    <input id="code" type="text" class="validate" name="code">
                    <label for="code">Votre code de sécurité</label>
                </div>
            </div>
            <div class="row">
                <span class="btn waves-effect waves-light" type="submit" name="login" onclick="handleForm()">Verifier
                    <i class="material-icons right">send</i>
                </span>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            handleForm();
        }
    });
    function handleForm(){

        const code = document.getElementById('code').value;

        console.log(code)
        if (code === "4532"){
            console.log("hello")
            swal("success", "verification effectué avec succes, redirection en cours ...", "success")
        }

    }
</script>