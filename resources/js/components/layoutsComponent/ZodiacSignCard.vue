<template>
    <fragment>
            <div class="card" :id="znak_zodiack.id">
                <img class="card-img-top" :src="znak_zodiack.image_link" alt="Знак зодиака">
                <div class="card-body text-center">
                    <p class="card-text">{{znak_zodiack.name_znak}}</p>
                    <p class="card-text">{{znak_zodiack.start_interval_date}} - {{znak_zodiack.finish_interval_date}}</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" :data-target='"#exampleModal№"+znak_zodiack.id'>
                        Прогноз
                    </button>
                    <div class="modal fade" :id='"exampleModal№"+znak_zodiack.id' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Знак зодиака: {{znak_zodiack.name_znak}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" v-if="znak_zodiack.text_prediction!==null">
                                    <p>{{znak_zodiack.text_prediction}}</p>
                                </div>
                                <div class="modal-body" v-else>
                                    <p>Нет предсказания на сегодня!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </fragment>
</template>

<script>
export default {
name: "ZodiacSignCard",
    props:{
        znak_zodiack:{default:null}
    },
    mounted() {
        console.log(this.znak_zodiack.text_prediction);
    }
}
</script>

<style scoped>

</style>
