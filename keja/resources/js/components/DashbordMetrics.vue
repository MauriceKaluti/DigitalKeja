<template>
    <div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 col-xl-3" v-loading="isLandlordLoading">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ landlords }}</h3>

                        <p>No of Landlord</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#!" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-4 col-xs-12 col-xl-3">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                        <p>Building</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-4 col-xs-12 col-xl-3">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>44</h3>

                        <p>No of tenants</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-4 col-xs-12 col-xl-3">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div>
</template>

<script>
    export default {
        name: "DashbordMetrics",
        data(){
            return{
                invoices: 0,
                landlords: 0,
                building: 0,
                isLandlordLoading : false,

            }
        },
        created() {

            setTimeout(() => {
                console.log('waiting ..');
                this.isLandlordLoading = true;
                this.getLandLords();
            } , 700000)

        },
        mounted() {
         // this.getLandLords();
        },
        methods: {
            getLandLords() {
                this.isLandlordLoading = true;

                window.axios.get('/get-landlords')
                    .then(res => {
                        this.landLords = res.data.landlords
                        this.isLandlordLoading = false;
                    }).catch(error => {
                        this.isLandlordLoading = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
