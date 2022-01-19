<template>
    <fragment>
        <main-header :authorized_user=authorized_user :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container">
            <div class="text-center">
                <form class="form-signin">
                    <input type="hidden" name="_token" :value="csrf">
                    <h1 class="h3 mb-3 font-weight-normal">Смена пароля</h1>
                    <label for="old_password">Старый пароль</label>
                    <input type="password" id="old_password" name="old_password" class="form-control margin_bottom_2" placeholder="Старый пароль"
                           required="" v-model="value_of_old_password">
                    <div class="checkbox mb-3">
                        <label><input type="checkbox" class="password-checkbox" id="password_checkbox1" @click="show_or_not_show_old_password">Показать
                            пароль</label>
                    </div>
                    <label for="new_password">Новый пароль</label>
                    <input type="password" id="new_password" name="new_password" class="form-control margin_bottom_2" placeholder="Новый пароль"
                           required="" v-model="value_of_new_password">
                    <div class="checkbox mb-3">
                        <label><input type="checkbox" class="password-checkbox" id="password_checkbox2" @click="show_or_not_show_new_password">Показать
                            пароль</label>
                    </div>

                    <button id="ChangePasswordButton" class="btn btn-lg btn-primary btn-block" type="button" @click="changePassword">Сменить пароль</button>
                    <br>
                </form>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
    name: "ChangePasswordPage",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        value_of_old_password:{defailt:null},
        value_of_new_password:{default:null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    props: {
        authorized_user: {default: null},
    },
    created() {
      this.value_of_old_password = "";
      this.value_of_new_password = "";
      this.flag_main_page = false;
      this.head_text = "Смена пароля";
    },
    methods:{
        changePassword()
        {
            if ((this.value_of_old_password!=="" || this.value_of_old_password!==null) && (this.value_of_new_password!=="" || this.value_of_new_password!==null))
            {
                document.getElementById('ChangePasswordButton').disabled = true;
                axios.post('/profile/changePassword',{
                    old_password: this.value_of_old_password,
                    new_password:this.value_of_new_password
                }).then(response=>{
                    if (response.data.Success===true)
                    {
                        this.$swal({
                            title: response.data.Message,
                            confirmButtonText: 'ОК',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/';
                            }
                        });
                    }
                    else
                    {
                        this.$swal({
                            title: response.data.Message,
                            icon:'error',
                            confirmButtonText: 'ОК',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('ChangePasswordButton').disabled = false;
                            }
                        });
                    }
                }).catch(error=>{
                    this.$swal({
                        title: error,
                        icon:'error',
                        confirmButtonText: 'ОК',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('ChangePasswordButton').disabled = false;
                        }
                    });
                });
            }
            else
            {
                this.$swal(
                    {
                        icon:'error',
                        title:"Не заполнены необходимы поля!"
                    }
                )
            }

        },
        show_or_not_show_new_password()
        {
            var checkbox_password = document.getElementById('password_checkbox2');
            var input_password = document.getElementById('new_password');
            if (checkbox_password.checked) {
                // показать пароль
                input_password.setAttribute('type', 'text');
            } else {
                //скрыть пароль
                input_password.setAttribute('type', 'password');
            }
        },
        show_or_not_show_old_password()
        {
            var checkbox_password = document.getElementById('password_checkbox1');
            var input_password = document.getElementById('old_password');
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
