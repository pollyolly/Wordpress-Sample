<div id="app-email-box">
    <div class="email-box">
        <div class="email-box-head">
            <h2 style="text-align: center;">Get our latest Pages News</h2>
        </div>
        <div class="email-box-content">
            <form class="subscribe-form" v-on:submit.prevent="subscribeEmail">
                <input type="hidden" name="crf" v-model="subscribe_crf">
                <div class="form-input">
                    <input type="text" name="fullname" placeholder="Fullname" class="email-input" v-model="subscribe_fullname">
                </div>
                <div class="form-input">
                    <input type="text" name="email" placeholder="Your email" class="email-input" v-model="subscribe_email">
                </div>
                <div class="form-input">
                    <img v-bind:src="'data:image/png;charset=utf8;base64,'+recaptcha" alt='Captcha' style='margin-right: 5px;float: left;height: 30px; width: 100px;'>
                    <input type="text" name="code" v-model="code" style="height: 30px;padding:0px 10px;width: 100px;" v-bind:disabled="!formstatus"/>
                </div>
                <input type="submit" class="email-submit" value="Subscribe Now" v-bind:disabled="!formstatus" v-bind:style="!formstatus ? {'display':'none !important'} : ''">
                <div v-text="formloading" style="font-size: 1.2em;color: #6f6e6e;" v-bind:style="formstatus ? {'display':'none !important'} : ''"></div>
            </form>
            <p v-if="errors.lenght">
                <ul style="margin: 0px !important; text-align: left;">
                    <li v-for="error in errors" v-bind:style="textstatus ? {'color':'#00573f'} : {'color':'#800000'}">{{ error }}</li>
                </ul>
            </p>
        </div>
    </div>
</div>