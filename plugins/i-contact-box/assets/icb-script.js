var icb_j = jQuery.noConflict();
var icontactBox = new Vue({
    el: '#app-icontact-box',
    data: {
        // topic: [
        //     {name:'UVLe', value:'UVLe'},
        //     {name:'MPM-RD (OVLe)', value:'MPMRD (OVLe)'},
        //     {name:'Training, Seminar or Workshop', value:'Training, Seminar or Workshop'},
        //     {name:'Internship Program', value:'Internship Program'},
        //     {name:'Other Services', value:'Other Services'},
        //     {name:'Other Concerns', value:'Other Concerns'}
        // ],
        // topicInput:'',
        // email: '',
        // fullname: '',
        // subject: '',
        // message: '',
        icbShow: true,
        //errors: ['Please fill the blanks.'],
         // formloading: '',
        // formstatus: true,
        //textstatus: false,
	   tooltipstat: true,
        // recaptcha: '',
        // code: '',
        // crf: '',
        // topiclist: []
    },
    mounted: function(){
        this.reloadCaptcha();
    },
    methods: {
        validateEmail: function(email){
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        reloadCaptcha: function(){
            icb_j.ajax({
                type: "POST",
                url: ajaxUrl.ajax_url,
                data: {
                    action: 'icb_getcaptcha_session'
                },
                cache: false,
                datatype: 'JSON',
                success: function(data){
                    let jdata = JSON.parse(data);
                    // icontactBox.recaptcha = jdata.image;
                    // icontactBox.crf = jdata.crf;
                    emailBox.recaptcha = jdata.image2;
                    emailBox.subscribe_crf = jdata.subscribe_crf;
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    }
});

var emailBox = new Vue({
    el: '#app-email-box',
    data: {
        subscribe_fullname: '',
        subscribe_email: '',
        subscribe_crf: '',
        errors: ['To get latest announcement of "Pages" please subscribe now.'],
        formloading: '',
        formstatus: true,
        textstatus: false,
        recaptcha: '',
        code: ''
    },
    methods: {
        subscribeEmail: function(){
            this.errors = [];
            if(!this.code){this.errors.push("Captcha is empty.");this.textstatus = false;}
            if(!this.subscribe_fullname){this.errors.push('Fullname field is empty.');this.textstatus = false;}
            if(!this.subscribe_email){this.errors.push('Email field is empty.');this.textstatus = false;}
            else if(!icontactBox.validateEmail(this.subscribe_email)){this.errors.push('Invalid Email.');this.textstatus = false;}
            if(this.subscribe_email && icontactBox.validateEmail(this.subscribe_email) && this.subscribe_fullname && this.code){
                this.formstatus = false;
                this.formloading = 'Please wait...';
                icb_j.ajax({
                    type: "POST",
                    url: ajaxUrl.ajax_url,
                    data: {
                        action: 'icb_email_save',
                        icb_srb_fullname: this.subscribe_fullname,
                        icb_srb_email: this.subscribe_email,
                        icb_srb_crf: this.subscribe_crf,
                        icb_crf_code: this.code
                    },
                    cache: false,
                    datatype: 'JSON',
                    success: function(data){
                        let jdata = JSON.parse(data);
                        emailBox.formstatus = true;
                        emailBox.textstatus = true;
                        emailBox.errors.push(jdata[0]);
                        icontactBox.reloadCaptcha();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        }
    }
});

