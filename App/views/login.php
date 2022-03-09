<div class="container">
    <div class="row">
        <form class="col s12" method="post" id="logForm">
            <div class="row">
                <div class="input-field col s12">
                    <input id="pseudo" type="text" class="validate" name="pseudo">
                    <label for="pseudo">Pseudo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" type="password" class="validate" name="password">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <span class="btn waves-effect waves-light" type="submit" name="login" onclick="handleForm()">Login
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
        const pseudo = document.getElementById('pseudo').value;
        const password = document.getElementById('password').value;

        if(pseudo.length === 0 || password.length === 0){
            swal("Error", "please fill in all fields", "error");
        }else{
            document.getElementById('logForm').submit();
        }

    }
</script>