<template>
    <fragment>
        <main-header :authorized_user=authorized_user :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container">
            <div class="text-center">
                <img class="mb-4" style="margin-top: 2%" src="images/logo_profile.png">
                <form class="form-signin" method="post" action="/infoAboutUser">
                    <input type="hidden" name="_token" :value="csrf">
                    <h1 class="h3 mb-3 font-weight-normal">Информация о пользователе</h1>
                    <label for="number_phone">Номер телефона</label>
                    <input type="tel" id="number_phone" name="number_phone" class="form-control margin_bottom_2"
                           placeholder="Номер телефона"
                           autofocus="" maxlength="255"
                            v-model="number_phone">
                    <label for="address">Адрес проживания</label>
                    <input type="text" id="address" name="address" class="form-control margin_bottom_2"
                           placeholder="Адрес проживания"
                           autofocus="" maxlength="255"
                            v-model="address">
                    <label for="profession">Профессия</label>
                    <input type="text" id="profession" name="profession" class="form-control margin_bottom_2"
                           placeholder="Профессия" maxlength="255" v-model="profession">
                    <label for="about_me">Обо мне</label>
                    <textarea id="about_me" name="about_me" class="form-control margin_bottom_2"
                              placeholder="Обо мне" maxlength="2500" v-model="about_me"></textarea>
                    <button class="btn btn-lg btn-primary btn-block" type="button" @click="sendInfoAboutMe">Подтвердить</button>
                    <br>
                </form>
                <button class="btn btn-lg btn-primary btn-block margin_bottom_2" type="button" @click="skip">Пропустить</button>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
    name: "InfoAboutNewUser",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        number_phone:"",
        address:"",
        profession:"",
        about_me:"",
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    props: {
        authorized_user: {default: null}
    },
    methods: {
        sendInfoAboutMe(){
            axios.post('/infoAboutUser',{
                number_phone:this.number_phone,
                address:this.address,
                profession:this.profession,
                about_me:this.about_me,
            }).then(()=>{
                    window.location.href="/";
                }
            ).catch(error=>{
                alert(error);
        })},
        skip(){
            axios.post('/infoAboutUser',{
                number_phone:"",
                address:"",
                profession:"",
                about_me:"",
            }).then((response)=>{
                if (response.data.Success===true) {
                    window.location.href = "/";
                }
            }).catch(error=>{
                alert(error);
            });
        }
    },
    created() {
        this.flag_main_page = false;
        this.head_text = "Информация о пользователе";
    }
}
</script>

<style scoped>

</style>
