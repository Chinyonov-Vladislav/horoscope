<template>
    <fragment>
        <main-header :authorized_user=authorized_user :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container" v-if="predictions_data.length>0">
            <div class="text-center">
                <h1 class="h3 mb-3 font-weight-normal">База предсказаний</h1>
                <button id="AddPredictionButton" class="btn btn-lg btn-success btn-block margin_bottom_2" type="button"
                        @click="GoToAddNewPrediction">Добавление предсказания
                </button>
                <a class="btn btn-success btn-lg btn-block margin_bottom_2" href="/predictions/download_excel" role="button">Экспорт предсказаний в excel</a>
                <table class="table table-bordered" v-if="predictions_data!==null">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Текст предсказания</th>
                        <th>Дата использования</th>
                        <th>Редактировать</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="prediction in predictions_data">
                        <td>{{ prediction.id }}</td>
                        <td>{{ prediction.text_prediction }}</td>
                        <td>{{ prediction.date_usage }}</td>
                        <td>
                            <button type="button" @click="RedactPrediction(prediction.id)" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                                </svg>
                            </button>
                        </td>
                        <td>
                            <button type="button" @click="DeletePrediction(prediction.id)" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="row" v-else>
                    <h3>Пока нет предсказаний</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 offset-md-4">
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="/predictions/page=1" tabindex="-1">В начало</a>
                            </li>
                            <li class="page-item disabled" v-if="number_current_page===1">
                                <a class="page-link" href="#" tabindex="-1">Предыдущая</a>
                            </li>
                            <li class="page-item" v-else>
                                <a class="page-link" :href='"/predictions/page="+(number_current_page-1)'
                                   tabindex="-1">Предыдущая</a>
                            </li>
                            <div v-if=" all_count_pages>=3">
                                <div class="pagination" v-if="number_current_page===1">
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ number_current_page }} <span
                                            class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           :href='"/predictions/page="+(number_current_page+1)'>{{ number_current_page + 1 }}</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           :href='"/predictions/page="+(number_current_page+2)'>{{ number_current_page + 2 }}</a>
                                    </li>
                                </div>
                                <div class="pagination" v-else-if="number_current_page=== all_count_pages">
                                    <li class="page-item">
                                        <a class="page-link"
                                           :href='"/predictions/page="+(number_current_page-1)'>{{ number_current_page - 1 }}</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           :href='"/predictions/page="+(number_current_page-2)'>{{ number_current_page - 2 }}</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ number_current_page }} <span
                                            class="sr-only">(current)</span></a>
                                    </li>
                                </div>
                                <div class="pagination" v-else>
                                    <li class="page-item">
                                        <a class="page-link"
                                           :href='"/predictions/page="+(number_current_page-1)'>{{ number_current_page - 1 }}</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ number_current_page }} <span
                                            class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           :href='"/predictions/page="+(number_current_page+1)'>{{ number_current_page + 1 }}</a>
                                    </li>
                                </div>
                            </div>
                            <div v-else>
                                <div class="pagination" v-if=" all_count_pages===1">
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ number_current_page }} <span
                                            class="sr-only">(current)</span></a>
                                    </li>
                                </div>
                                <div v-if="all_count_pages===2">
                                    <div class="pagination" v-if="number_current_page===1">
                                        <li class="page-item active">
                                            <a class="page-link" href="#">{{ number_current_page }} <span
                                                class="sr-only">(current)</span></a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link"
                                               :href='"/predictions/page="+(number_current_page+1)'>{{ number_current_page + 1 }}</a>
                                        </li>
                                    </div>
                                    <div class="pagination" v-if="number_current_page===2">
                                        <li class="page-item">
                                            <a class="page-link"
                                               :href='"/predictions/page="+(number_current_page-1)'>{{ number_current_page - 1 }}</a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">{{ number_current_page }} <span
                                                class="sr-only">(current)</span></a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                            <li class="page-item disabled" v-if="number_current_page=== all_count_pages">
                                <a class="page-link" href="#" tabindex="-1">Следующая</a>
                            </li>
                            <li class="page-item" v-else>
                                <a class="page-link" :href='"/predictions/page="+(number_current_page+1)'
                                   tabindex="-1">Следующая</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" :href="'/predictions/page='+ all_count_pages" tabindex="-1">В конец</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container" v-else>
            <div class="text-center">
                <h1 class="h3 mb-3 font-weight-normal">База предсказаний</h1>
                <h1 class="h3 mb-3 font-weight-normal">Предсказаний еще нет. Добавьте своё первое предсказание</h1>
                <button id="AddFirstPredictionButton" class="btn btn-lg btn-success btn-block margin_bottom_2" type="button"
                        @click="GoToAddNewPrediction">Добавление предсказания
                </button>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
    name: "PredictionsPage",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        number_current_page: {default:null},
        all_count_pages:{default:null},
        predictions_data: {default: null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    props: {
        authorized_user: {default: null},
        predictions: {default: null},
        numbers_pages: {default: null},
        current_page: {default: null}
    },
    created() {
        this.predictions_data = this.predictions;
        this.number_current_page = parseInt(this.current_page);
        this.all_count_pages = parseInt(this.numbers_pages)
        this.head_text="База предсказаний";
        this.flag_main_page = false;
    },
    methods: {
        GoToAddNewPrediction() {
            window.location.href = '/predictions/add';
        },
        RedactPrediction(id) {
            window.location.href = "/predictions/redact/" + id;
        },
        DeletePrediction(id) {
            axios.delete('/predictions/delete/' + id,{data: {
                    current_page: this.number_current_page,
                    all_count_page: this. all_count_pages
                }
            }).then(response => {
                if (response.data.Success === true) {
                    console.log(response.data)
                    if (response.data.Count_all_pages===0)
                    {
                        this.number_current_page = response.data.Number_page;
                        this.all_count_pages = response.data.Count_all_pages;
                        this.predictions_data = response.data.Predictions;
                    }
                    else if(response.data.Count_all_pages === this.all_count_pages)
                    {
                        if (response.data.Number_page === this.number_current_page)
                        {
                            console.log("3213");
                            this.number_current_page = response.data.Number_page;
                            this.all_count_pages = response.data.Count_all_pages;
                            this.predictions_data = response.data.Predictions;
                        }
                        else
                        {
                            console.log('/predictions/page='+response.data.Number_page);
                            window.location.href = '/predictions/page='+response.data.Number_page;
                        }
                    }
                    else
                    {
                        if (response.data.Number_page === this.number_current_page)
                        {
                            this.number_current_page = response.data.Number_page;
                            this.all_count_pages = response.data.Count_all_pages;
                            this.predictions_data = response.data.Predictions;
                        }
                        else
                        {
                            window.location.href = '/predictions/page='+response.data.Number_page;
                        }
                    }

                    //window.location.href='/predictions/page='+response.data.Number_page;
                } else {
                    alert(response.data.Message);
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
