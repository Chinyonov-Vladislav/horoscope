<template>
    <fragment>
        <main-header :authorized_user=authorized_user :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container" v-if="type_action===true">
            <div class="text-center">
                <form class="form-signin">
                    <input type="hidden" name="_token" :value="csrf">
                    <label for="text_prediction">Текст предсказания</label>
                    <textarea id="text_prediction" name="text_prediction" class="form-control margin_bottom_2"
                              placeholder="Текст предсказания" maxlength="5000" v-model="text_prediction"
                              @keyup="pressKey"></textarea>
                    <div class v-if="errors!==null">
                        <div v-for="error in errors">
                            <p style="color: red">{{ error }}</p>
                        </div>
                    </div>
                    <p>Количество символов: {{ count_symbols }}/5000</p>
                    <button class="btn btn-lg btn-primary btn-block" type="button" @click="AddNewPrediction">
                        Подтвердить
                    </button>
                    <br>
                </form>
            </div>
        </div>
        <div class="container" v-else>
            <div class="text-center">
                <form class="form-signin">
                    <input type="hidden" name="_token" :value="csrf">
                    <label for="text_prediction_redact">Текст предсказания</label>
                    <textarea id="text_prediction_redact" name="text_prediction_redact"
                              class="form-control margin_bottom_2"
                              placeholder="Текст предсказания" maxlength="5000" v-model="text_prediction"
                              @keyup="pressKey"></textarea>
                    <div class v-if="errors!==null">
                        <div v-for="error in errors">
                            <p style="color: red">{{ error }}</p>
                        </div>
                    </div>
                    <p>Количество символов: {{ count_symbols }}/5000</p>
                    <button class="btn btn-lg btn-primary btn-block" type="button"
                            @click="RedactPrediction(id_prediction)">Сохранить
                    </button>
                    <br>
                </form>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
    name: "ActionWithPredictionPage",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        errors: {default: null},
        count_symbols: {default: null},
        id_prediction: {default: null},
        text_prediction: {default: null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    props: {
        type_action: {default: null},
        authorized_user: {default: null},
        prediction: {default: null}
    },
    created() {
        this.flag_main_page = false;
        if (this.type_action === true)//добавление
        {
            this.head_text = "Добавление предсказания";
            this.count_symbols = 0;
            this.errors = null;
            this.text_prediction = "";
        } else // редактирование
        {
            try {
                this.head_text = "Редактирование предсказания";
                this.count_symbols = this.prediction[0].text_prediction.length;
                this.text_prediction = this.prediction[0].text_prediction;
                this.id_prediction = this.prediction[0].id;
                this.errors = null;
            } catch (error) {
                alert(error);
                window.location.href = '/predictions/page=1';
            }
            ;
        }
    },
    methods: {
        pressKey() {
            if (this.type_action === true) {
                this.count_symbols = document.getElementById("text_prediction").value.length;
            } else {
                this.count_symbols = document.getElementById("text_prediction_redact").value.length;
            }
        },
        RedactPrediction(id) {
            axios.post("/predictions/redact", {
                id_prediction: id,
                text_prediction: this.text_prediction
            }).then(response => {
                if (response.data.Error_Validation === true) {
                    this.errors = response.data.Message.text_prediction;
                } else {
                    if (response.data.Success === true) {
                        window.location.href = '/predictions/page=1';
                    } else {
                        alert(response.data.Message);
                    }
                }
            }).catch(error => {
                alert(error)
            })
        },
        AddNewPrediction() {
            axios.post('/predictions/add', {
                text_prediction: this.text_prediction
            }).then(response => {
                if (response.data.Error_Validation === true) {
                    this.errors = response.data.Message.text_prediction;
                } else {
                    if (response.data.Success === true) {
                        window.location.href = '/predictions/page=1';
                    }
                    if (response.data.Success === false) {
                        alert(response.data.Message)
                    }
                }
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
