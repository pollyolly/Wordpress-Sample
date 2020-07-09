<div id="app-icontact-box">
    <div class="icontact-box-button" style="z-index:9999999;" v-on:click="icbShow = !icbShow">
	<span class="icontact-envelope fa" v-bind:class="icbShow ? 'fa-envelope' : 'fa-envelope-open'" v-on:mouseover="tooltipstat = !tooltipstat"></span>
	<div class="data-tooltips" v-bind:style="tooltipstat ? '':{'visibility':'visible'}">Email us</div>
    </div>
    <div id="icontact-box" class="icontact-box" v-bind:class="icbShow ? 'contact-box_close' : 'contact-box_open slideInUp animated'">
        <div class="icontact-box-head" v-on:click="icbShow = !icbShow">
            <span class="icontact-envelope fa fa-envelope"></span>
            <span>Email us</span>
            <span class="icontact-times fa fa-times"></span>
        </div>
        <div class="icontact-box-content">
            <embed style="height: 100%;" src="https://helpdesk.ilc.upd.edu.ph/o.php" />
        </div>
    </div>
</div>

