<template>
    <fragment>
        <main-header :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container">

            <div class="text-center">
                <form class="form-signin" method="post" action="/login">
                    <input type="hidden" name="_token" :value="csrf">
                    <img class="mb-4" style="margin-top: 2%" src="images/logo_auth.png">
                    <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
                    <label for="email">Email-адрес</label>
                    <input type="email" id="email" name="email" class="form-control margin_bottom_2" placeholder="Email-адрес"
                           required=""
                           autofocus="">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-control margin_bottom_2" placeholder="Пароль"
                           required="">
                    <div class="checkbox mb-3">
                        <label><input type="checkbox" class="password-checkbox" id="password_checkbox" @click="show_or_not_show_password">Показать
                            пароль</label>
                    </div>
                    <div class="checkbox mb-3">
                        <label><input type="checkbox" value="remember-me">Запомнить меня</label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
                    <br>
                </form>
                <h4 class="font-weight-normal">Восстановление пароля</h4>
                <button class="btn btn-lg btn-primary btn-block margin_bottom_2" type="button"
                        @click="GoToRecoveryPassword">Забыли пароль
                </button>
                <h4 class="font-weight-normal">До сих пор нет аккаунта?</h4>
                <button class="btn btn-lg btn-primary btn-block margin_bottom_2" type="button"
                        @click="GoToRegistration">Зарегистрировать аккаунт
                </button>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
    name: "authorizationPage",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    created() {
      this.head_text="Авторизация";
      this.flag_main_page = false;
    },
    methods: {
        GoToRegistration() {
            window.location.href = "/register";
        },
        GoToRecoveryPassword() {
            window.location.href = "/password/reset";
        },
        show_or_not_show_password() {
            var checkbox_password = document.getElementById('password_checkbox');
            var input_password = document.getElementById('password');
            if (checkbox_password.checked) {
                // показать пароль
                input_password.setAttribute('type', 'text');
            } else {
                //скрыть пароль
                input_password.setAttribute('type', 'password');
            }
        }
    }
}
</script>

<style scoped>

</style>
