<template>
    <fragment>
        <section class="header navigation bg-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-md">
                            <div class="col-md-4">
                                <a class="navbar-brand" href="#">
                                    <img src="/images/logo.png" alt="logo">
                                </a>
                            </div>
                            <div class="col-md-4">
                                <div class="row" v-if="flag">
                                    <h3>{{ text_in_header }} {{ date }}</h3>
                                </div>
                                <div class="row" v-else>
                                    <h3>{{ text_in_header }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                                         class="bi bi-filter-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                        <path
                                            d="M6 11.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
                                    </svg>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                    <ul class="navbar-nav ml-auto">
                                        <li class="margin_right_2 margin_bottom_2">
                                            <button type="button" class="btn btn-success" @click="GoToMainPage">Главная
                                            </button>
                                        </li>
                                        <li class="margin_right_2 margin_bottom_2" v-if="authorized_user===null">
                                            <button type="button" class="btn btn-success" @click="GoToAuth">Войти
                                            </button>
                                        </li>
                                        <li class="margin_right_2 margin_bottom_2" v-if="authorized_user!==null">
                                            <form action="/predictions/page=1" method="get">
                                                <input type="hidden" name="_token" :value="csrf">
                                                <button type="submit" class="btn btn-success">Предсказания</button>
                                            </form>
                                        </li>
                                        <li class="margin_right_2 margin_bottom_2" v-if="authorized_user!==null">
                                            <form action="/profile" method="get">
                                                <input type="hidden" name="_token" :value="csrf">
                                                <button type="submit" class="btn btn-success">Профиль</button>
                                            </form>
                                        </li>
                                        <li class="margin_right_2 margin_bottom_2" v-if="authorized_user!==null">
                                            <form action="/logout" method="post">
                                                <input type="hidden" name="_token" :value="csrf">
                                                <button type="submit" class="btn btn-success">Выйти</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </nav>

                    </div>
                </div>
            </div>
        </section>
    </fragment>
</template>

<script>
export default {
    name: "header",
    data: () => ({
        date: {default: null},
        text_in_header: {default: null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    props: {
        flag: {default: null},
        header_text: {default: null},
        date_from_main_page: {default: null},
        authorized_user: {default: null},
    },
    created() {
        this.text_in_header = this.header_text;
        if (this.flag === true) {
            this.date = this.date_from_main_page;
        }
    },
    watch:{
        date_from_main_page:function ()
        {
            console.log("computed")
            if (this.flag === true) {
                this.date = this.date_from_main_page;
            }
        }
    },
    methods: {
        GoToMainPage() {
            window.location.href = "/";
        },
        GoToAuth() {
            window.location.href = "/login";
        }
    }
}
</script>

<style scoped>

</style>
