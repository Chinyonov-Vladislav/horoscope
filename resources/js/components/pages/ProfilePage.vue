<template>
    <fragment>
        <main-header :authorized_user=authorized_user :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container">
            <div class="text-center">
                <h1 class="h3 mb-3 font-weight-normal">Мой профиль</h1>
                <label for="name">Nickname (имя профиля)</label>
                <input type="text" id="name" name="name" class="form-control margin_bottom_2" placeholder="Nickname" required
                       autofocus="" autocomplete="off" disabled v-model="user_info.name">
                <label for="email">Email - адрес</label>
                <input type="text" id="email" name="email" class="form-control margin_bottom_2" placeholder="Email - адрес" required
                       autofocus="" autocomplete="off" disabled v-model="user_info.email">
                <label for="number_phone">Номер телефона</label>
                <input type="text" id="number_phone" name="number_phone" class="form-control margin_bottom_2" placeholder="Номер телефона" required
                       autofocus="" autocomplete="off" disabled v-model="user_info.number_phone">
                <label for="address">Адрес проживания</label>
                <input type="text" id="address" name="address" class="form-control margin_bottom_2" placeholder="Адрес проживания" required
                       autofocus="" autocomplete="off" disabled v-model="user_info.address">
                <label for="profession">Профессия</label>
                <input type="text" id="profession" name="profession" class="form-control margin_bottom_2" placeholder="Профессия" required
                       autofocus="" autocomplete="off" disabled v-model="user_info.profession">
                <label for="about_me">Обо мне</label>
                <textarea type="text" id="about_me" name="about_me" class="form-control margin_bottom_2" placeholder="Обо мне" required
                          autofocus="" autocomplete="off" disabled v-model="user_info.about_me"></textarea>
                <button id="RedactButton" class="btn btn-lg btn-primary btn-block margin_bottom_2" type="button" @click="Redact">Редактировать</button>
                <button id="ChangePasswordButton" class="btn btn-lg btn-primary btn-block margin_bottom_2" type="button" @click="ChangePassword">Сменить пароль</button>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
    name: "ProfilePage",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
       user_info:{default:null}
    }),
    props: {
        authorized_user: {default: null},
        info_user:{default:null}
    },
    created() {
        this.flag_main_page = false;
        this.head_text="Профиль пользователя"
        if (this.info_user.length===1) {
            this.user_info = this.info_user[0];
        }
    },
    methods:{
        ChangePassword()
        {
          window.location.href='/profile/changePassword';
        },
        Redact(){
            let button = document.getElementById("RedactButton");
            if(button.textContent==="Редактировать")
            {
                let inputs = document.getElementsByTagName(`input`);
                for(let i =0; i<inputs.length;i++)
                {
                    if (inputs[i].name!=="email") {
                        inputs[i].disabled = false;
                    }
                }
                let textareas = document.getElementsByTagName('textarea');
                for (let i=0 ; i< textareas.length;i++)
                {
                    textareas[i].disabled = false;
                }
                button.textContent="Сохранить";
                return
            }
            if (button.textContent === "Сохранить"){
                axios.post('/redactInfoAboutUser',{
                    nickname:this.user_info.name,
                    address:this.user_info.address,
                    about_me:this.user_info.about_me,
                    number_phone:this.user_info.number_phone,
                    profession:this.user_info.profession
                }).then(response=>{
                    if (response.data.Success===true)
                    {
                        let inputs = document.getElementsByTagName(`input`);
                        for(let i =0; i<inputs.length;i++)
                        {
                            if (inputs[i].name!=="email") {
                                inputs[i].disabled = true;
                            }
                        }
                        let textareas = document.getElementsByTagName('textarea');
                        for (let i=0 ; i< textareas.length;i++)
                        {
                            textareas[i].disabled = true;
                        }
                        button.textContent="Редактировать";
                    }
                }).catch(error=>{
                    console.log(error)
                })
            }


        }
    }
}
</script>

<style scoped>

</style>
