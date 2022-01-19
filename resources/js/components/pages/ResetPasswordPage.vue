<template>
    <fragment>
        <main-header :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container">
            <div class="text-center">
                <form class="form-signin">
                    <input type="hidden" name="_token" :value="csrf">
                    <img class="mb-4" style="margin-top: 2%" src="/images/password_reset.png">
                    <h1 class="h3 mb-3 font-weight-normal">Восстановление пароля</h1>
                    <label for="email">Email-адрес</label>
                    <input type="email" id="email" name="email" class="form-control margin_bottom_2" placeholder="Email-адрес"
                           required=""
                           autofocus=""
                    v-model="email">
                    <button class="btn btn-lg btn-primary btn-block" id="resetPasswordButton" type="button" @click="SendNewPassword">Отправить новый пароль</button>
                    <br>
                </form>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
    name: "ResetPasswordPage",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        email:{default:null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    methods:{

        SendNewPassword(){
            if(this.email==="")
            {
                this.$swal('Поле email не заполнено!');
            }
            else
            {
                document.getElementById('resetPasswordButton').disabled = true;
                axios.post('/reset-password',
                    {email:this.email}).then(response=>{
                    if (response.data.Error_Validation)
                    {
                        let message_error = "";
                        for (let i=0 ;i<response.data.Message.email.length;i++)
                        {
                            message_error+=response.data.Message.email[i]+"\n";
                        }
                        this.$swal({
                            icon: 'error',
                            title: message_error,
                            confirmButtonText: 'ОК',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('resetPasswordButton').disabled = false;
                            }
                        });
                    }
                    else {
                        if (response.data.Success === true) {
                            this.$swal({
                                title: response.data.Message,
                                confirmButtonText: 'ОК',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/login';
                                }
                            });
                        } else {
                            this.$swal(response.data.Message);
                        }
                    }
                }).catch(error=>{
                    this.$swal(error);
                })
            }

        }
    },
    created() {
        this.email = "";
        this.flag_main_page = false;
        this.head_text = "Восстановление пароля";
    }
}
</script>

<style scoped>

</style>
