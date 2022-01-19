<template>
    <fragment>
        <main-header :authorized_user = authorized_user :date_from_main_page="string_date_for_header" :header_text="head_text" :flag="flag_main_page"></main-header>
        <div class="container">
            <button type="button" class="btn btn-primary btn-block" style="margin-top: 2%" data-toggle="modal" data-target="#dateModal">
                фильтрация по дате
            </button>
            <!-- Modal -->
            <div class="modal fade" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Фильтрация по дате</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <VueDatePicker id="calendar" v-model="date" format="D.M.YYYY" :minDate="this.min_date" :maxDate="this.max_date" ></VueDatePicker>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="showPredictionOnDate">Применить фильтр</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 margin_bottom_2" v-for="item in signs_zodiack">
                        <zodiac-sign-card :znak_zodiack="item"></zodiac-sign-card>
                    </div>
                </div>
            </div>
        </div>
        <main-footer></main-footer>
    </fragment>
</template>

<script>
export default {
    name: "MainPage",
    data: () => ({
        flag_main_page:{default:null},
        head_text:{default:null},
        date: new Date(),
        min_date:new Date(),
        max_date:new Date(),
        signs_zodiack:{default:null},
        string_date_for_header:{default:null},
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    props:{
        authorized_user:{default:null},
        info_about_zodiac_znak:{default: null},
    },
    created() {
      this.signs_zodiack = this.info_about_zodiac_znak;
      this.head_text="Гороскоп на";
      this.flag_main_page = true;
      this.min_date.setDate(this.min_date.getDate()-29);
      this.string_date_for_header = this.date.getDate().toString() + ".";
      if(this.date.getMonth() + 1 >=10)
      {
          this.string_date_for_header+=(this.date.getMonth() + 1).toString() + "."+ this.date.getFullYear().toString();
      }
      else
      {
          this.string_date_for_header+="0"+(this.date.getMonth() + 1).toString() + "."+ this.date.getFullYear().toString();
      }


    },
    methods:{
        showPredictionOnDate()
        {
            axios.post('/predictions/showPredictionByDay',{
                date_from_calendar: this.date
            }).then(response=>{
                if (response.data.Success===true)
                {
                    this.signs_zodiack = response.data.Info_about_signs_date;
                    this.string_date_for_header = response.data.formated_date;
                }
                else
                {
                    this.$swal({
                        icon:'error',
                        title:response.data.Message,
                        confirmButtonText: 'ОК',
                    }).then(result=>{
                        if (result.isConfirmed)
                        {
                            window.location.reload();
                        }
                    });
                }
            }).catch(error=>{
                this.$swal({
                    icon:'error',
                    title:error,
                    confirmButtonText: 'ОК',
                }).then(result=>{
                    if (result.isConfirmed)
                    {
                        window.location.reload();
                    }
                });
            })
        }
    }
}
</script>

<style scoped>
</style>
