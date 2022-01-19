<template>
    <fragment>
        <main-header :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container">
            <div class="text-center">
                    <img class="mb-4" style="margin-top: 2%" src="images/logo_registration.png">
                <form class="form-signin needs-validation" method="post" action="/register" @submit="show">
                    <input type="hidden" name="_token" :value="csrf">
                    <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
                    <label for="name" >Nickname</label>
                    <input type="text" id="name" name="name" class="form-control margin_bottom_2" placeholder="Nickname" required
                           autofocus="" autocomplete="off">
                    <label for="email">Email-адрес</label>
                    <input type="email" id="email" name="email"  class="form-control margin_bottom_2" placeholder="Email-адрес" required
                           autofocus="" autocomplete="off">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-control margin_bottom_2" placeholder="Пароль" required autocomplete="off">
                    <label for="password-confirm">Повторите пароль</label>
                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control margin_bottom_2" placeholder="Повторите пароль" required autocomplete="off">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
                    <br>
                </form>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
name: "RegistrationPage",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    methods:{
        /*submitForm(){
            axios.post('/register',{
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            }).then().catch(e=>{
                console.log(e)
            });
        },*/
        show(){
            console.log(document.getElementById('name').value);
            console.log(document.getElementById('email').value);
            console.log(document.getElementById('password').value);
            console.log(document.getElementById('password-confirm').value);
        }
    },
    created() {
        this.flag_main_page = false;
        this.head_text = "Регистрация";
    }
}
</script>

<style scoped>

</style>
