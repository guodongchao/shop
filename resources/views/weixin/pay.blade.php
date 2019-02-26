
<script src="{{ asset('/qrcodejs/qrcode.js')}}"></script>

<div id="qrcode" style="width: 560px;height: 560px;background-color: white;"></div>
</div>


</div>
</template>

<script>
    import QRCode from 'qrcodejs2';
    import Cookie from 'vue-cookies';
    export default {
        name: "binding-weixin",
        data() {
            return {
                qrcode: ''
            }
        },
        methods: {
            getBindUserQcode: function () {
                let csrftoken = Cookie.get('csrftoken');
                this.$axios.request({
                    url: this.$store.state.apiList.bindingWeixin,
                    method: 'get',
                    // params: {foo: 'bar'},
                    headers: {"X-CSRFToken": csrftoken}
                }).then(res => {
                    this.qrcode.clear();
                    this.qrcode.makeCode(res.data.data);
                    console.log(res.data.data, 22222222222222222)
                }).catch(res => {
                    console.log(res, 1111111111111111111)
                })
            }
        },
        mounted() {
            this.qrcode = new QRCode('qrcode', {
                text: '',
                width: 200,
                height: 200,
                // render: 'canvas' // 设置渲染方式（有两种方式 table和canvas，默认是canvas）
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: 3
            })
        }
    }
</script>


