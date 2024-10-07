var Inex = function() {
    return {
        redirect_to: function (url){
            window.location=url;
        },

        redirect_back:function(){
            history.go(-1);
        },
        reload_page:function(){
            location.reload();
        },

        only:function(val,el){
            if(val=="digit"){
                if(document.getElementById(el).value.match(/[^0-9]/g)) {
                    document.getElementById(el).value = document.getElementById(el).value.replace(/[^0-9]/g, '');
                }
            }if(val=="int_flot"){
                if(document.getElementById(el).value.match(/[^0-9.]/g)) {
                    document.getElementById(el).value = document.getElementById(el).value.replace(/[^0-9]/g, '');
                }
            }else if(val=="alpha"){
                if(document.getElementById(el).value.match(/[^a-zA-Z]/g)) {
                    document.getElementById(el).value = document.getElementById(el).value.replace(/[^a-zA-Z]/g, '');
                }
            }else if(val=="only_string"){
                if(document.getElementById(el).value.match(/[^a-zA-Z .]/g)) {
                    document.getElementById(el).value = document.getElementById(el).value.replace(/[^a-zA-Z]/g, '');
                }
            }else if(val=="alpha_digit"){
                if(document.getElementById(el).value.match(/[^a-zA-Z0-9]/g)) {
                    document.getElementById(el).value = document.getElementById(el).value.replace(/[^a-zA-Z0-9]/g, '');
                }
            }else if(val=="alpha_digit_space"){
                if(document.getElementById(el).value.match(/[^a-zA-Z0-9 ]/g)) {
                    document.getElementById(el).value = document.getElementById(el).value.replace(/[^a-zA-Z0-9 ]/g, '');
                }
            }else if(val=="alpha_space"){
                if(document.getElementById(el).value.match(/[^a-zA-Z0-9 ]/g)) {
                    document.getElementById(el).value = document.getElementById(el).value.replace(/[^a-zA-Z ]/g, '');
                }
            }else if(val=="alpha_digit_space_hifun"){
                if(document.getElementById(el).value.match(/[^a-zA-Z0-9 -]/g)) {
                    document.getElementById(el).value = document.getElementById(el).value.replace(/[^a-zA-Z0-9 -]/g, '');
                }
            }
        },
        conform_model:function(event,th,msg){
            event.preventDefault();

            bootbox.confirm(msg, function(result) {
                //return result;
                result && document.location.assign($(th).attr('href'));
            });
            //return false;
        },
        alert_model:function(text){
            bootbox.alert(text);
            //return false;
        },

        placeApi:function(element,element_city,element_state,element_country,element_place_id){
            var input = /** @type {HTMLInputElement} */(document.getElementById(element));
            /*var options = {
                componentRestrictions: {country: "in"}
            };
            var autocomplete = new google.maps.places.Autocomplete(input,options);*/
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                /*$("#result").html('');*/
                var types_arr;
                $("#"+element_place_id).val(place.place_id);
                var city='';
                var state='';
                var country='';
                $.each(place.address_components, function(index,value){
                    //$("#result").html($("#result").html()+'<label><strong>'+index+'</strong>:&nbsp;&nbsp;</label>'+value+'<br>');
                    /*$.each(this.types,function(index,value){
                     alert(this.index);
                     });*/
                    var locality=0;
                    var administrative_area_level_2=0;
                    var administrative_area_level_1=0;
                    var country=0;
                    //alert(place.place_id);
                    $.each(this.types, function(index,value){
                        //alert(index+' -- '+value);
                        if(value=='locality'){ locality++; return; };
                        if(value=='administrative_area_level_2'){ administrative_area_level_2++; return; };
                        if(value=='administrative_area_level_1'){ administrative_area_level_1++; return; };
                        if(value=='country'){ country++; return; };
                    });

                    if(locality>0){
                        city=this.long_name;
                        $("#"+element_city).val(this.long_name);
                    }else if(administrative_area_level_1>0){
                        state=this.long_name;
                        if(city==''){
                            //$("#"+element_city).val(this.long_name);
                            $("#"+element_city).val('');
                        }
                        $("#"+element_state).val(this.long_name);
                    }else if(country>0){
                        country=this.long_name;
                        if(state==''){
                            //$("#"+element_state).val(this.long_name);
                            $("#"+element_state).val('');
                        }
                        if(city==''){
                            if(state!=''){
                                //$("#"+element_city).val(state);
                                $("#"+element_city).val('');
                            }else{
                                //$("#"+element_city).val(this.long_name);
                                $("#"+element_city).val('');
                            }
                        }

                        $("#"+element_country).val(this.long_name);
                    }else{

                    }
                });
                //alert(JSON.stringify(place));
            });
        },

        placeApi_2:function(element,element_city,element_state,element_country,element_place_id){
            var placeSearch, autocomplete;
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
            };

            function initAutocomplete() {
                var input = document.getElementById(element);
                var options = {
                    types: ['(geocode)']
                };
                autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', fillInAddress);
            }

            function fillInAddress() {
                var place = autocomplete.getPlace();

                for (var component in componentForm) {
                    document.getElementById(component).value = '';
                    document.getElementById(component).disabled = false;
                }

                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById(addressType).value = val;
                    }
                }
            }
            function geolocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        var circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        autocomplete.setBounds(circle.getBounds());
                    });
                }
            }
        },

        highlight_test:function(text,element){
            regex = new RegExp(text, 'ig');
            $('#'+element).highlightRegex(regex);
        },

        copyToClipboard:function(elem){
            // create hidden text element, if it doesn't already exist
            $(elem).select();

            var targetId = "_hiddenCopyText_";
            var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
            var origSelectionStart, origSelectionEnd;
            if (isInput) {
                // can just use the original source element for the selection and copy
                target = elem;
                origSelectionStart = elem.selectionStart;
                origSelectionEnd = elem.selectionEnd;
            } else {
                // must use a temporary form element for the selection and copy
                target = document.getElementById(targetId);
                if (!target) {
                    var target = document.createElement("textarea");
                    target.style.position = "absolute";
                    target.style.left = "-9999px";
                    target.style.top = "0";
                    target.id = targetId;
                    document.body.appendChild(target);
                }
                target.textContent = elem.textContent;
            }
            // select the content
            var currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);
            // copy the selection
            var succeed;
            try {
                succeed = document.execCommand("copy");
            } catch(e) {
                succeed = false;
            }
            // restore original focus
            if (currentFocus && typeof currentFocus.focus === "function") {
                currentFocus.focus();
            }
            if (isInput) {
                // restore prior selection
                elem.setSelectionRange(origSelectionStart, origSelectionEnd);
            } else {
                // clear temporary content
                target.textContent = "";
            }
            return succeed;
        },

        regx:function(elem){
            if(elem == 'mobile'){
                return /^[0-9]{4,12}$/;
            }else if(elem == 'email'){
                return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
            }else if(elem == 'only_alpha'){
                return /^[a-zA-Z]+$/;
            }else if(elem == 'only_digit'){
                return /^[0-9]+$/;
            }else if(elem == 'int_flot'){
                return /^(?=.*\d)\d*(?:\.\d+)?$/;
            }else if(elem == 'only_alpha_number'){
                return /^[a-zA-Z0-9]+$/;
            }else if(elem == 'only_alpha_space'){
                return /^[a-zA-Z ]+$/;
            }else if(elem == 'url'){
                return /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
            }else if(elem == 'number'){
                return /^[0-9]{1,6}$/;
            }else if(elem == 'only_alpha_number_space') {
                return /^[a-zA-Z0-9 ]+$/;
            }else if(elem == 'only_alpha_number_space_hifun') {
                return /^[a-zA-Z0-9 -]+$/;
            }else if(elem == 'only_alpha_number_hifun') {
                return /^[a-zA-Z0-9-]+$/;
            }else if(elem== 'url_general'){
                return /(https|http|ftp)\:\/\/|([a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4})|([a-z0-9A-Z]+\.[a-zA-Z]{2,4})|\?([a-zA-Z0-9]+[\&\=\#a-z]+)/i;
            }else if(elem== 'numeric_3_decimal_point'){
                return /^\d+(\.\d{1,3})?$/;
            }else if(elem== 'numeric_2_decimal_point_with_postfix'){
                return /^\d+(\.\d{1,2})?ct\b$/;
            }else if(elem == 'only_english_cher') {
                return /^[a-zA-Z0-9 !@#%*()_+-=]+$/;
            }else if(elem== 'digit_with_two_decimal'){
                return /^\d+(\.\d{1,2})?$/;
            }else if(elem== 'digit_with_three_decimal'){
                return /^\d+(\.\d{1,3})?$/;
            }
        },

        scroll_upto_div:function(element_id){
            $("html, body").animate({
                scrollTop: $("#"+element_id).offset().top-180
            }, 600);
        },

        get_page_name:function(url) {
            var index = url.lastIndexOf("/") + 1;
            var filenameWithExtension = url.substr(index);
            var filename = filenameWithExtension.split(".")[0];
            return filename;
        },

        replace_strinng:function(){
        },

        getCookie:function(cname){
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length,c.length);
                }
            }
            return "";
        },
        setTimeOutAlerts:function(){
            setTimeout(function() {
                //$(".alert").css("display", "none");
                $('.alert').each(function () {
                    if($(this).attr('role')=='alert'){
                        $(this).fadeOut();
                    }
                });
            }, 5000);
        },

        process_chunk_image_with_module:function(chunk,file_name,last_chunk,module,upload_url,csrf_token){
            $.ajax({
                type:"POST",
                url:upload_url,
                data: {
                    _token:csrf_token,
                    image_chunk: chunk,
                    file_name:file_name,
                    last_chunk: last_chunk,
                    module: module
                },
                async: false,
                success: function (responce) {
                    var responce_obj=JSON.parse(responce);
                    $("#file_name_temp").val(responce_obj.file_name);
                    if(last_chunk==1){
                        $("#file_name_temp").val('');
                        var image_url_json = $("#image_url_json").val();
                        if (image_url_json == '') {
                            var jsonObj = [];
                        } else {
                            var jsonObj = JSON.parse(image_url_json);
                        }
                        var item = {};
                        item["src"] = responce_obj.image_name;
                        jsonObj.push(item);
                        $("#image_url_json").val(JSON.stringify(jsonObj));
                    }
                }
            });
        },

        chunk_image:function(base64,image_size,image_type,ext,upload_route,config_img_location,tmp_file_name_id,hidden_image_name_id,image_div_class_id,size_limit,type_limit,csrf_token){

            var flag = 0;
            $("#"+hidden_image_name_id).val('');

            $(image_div_class_id).show();
            if(size_limit!=''){
                if(parseInt(image_size) > parseInt(size_limit)){
                    flag++;
                    $(image_div_class_id).hide();
                    this.alert_model('Image size should be less than '+parseInt(parseInt(size_limit)/1024)+' KB');
                }
            }

            if(type_limit!=''){
                if(flag==0){
                    var type_arr = type_limit.split(',');
                    if($.inArray(image_type.toLowerCase(),type_arr) == '-1'){
                        flag++;
                        $(image_div_class_id).hide();
                        this.alert_model('File is invalid.');
                    }
                }
            }

            if(flag==0){
                var arr=base64.match(/.{1,500000}/g);
                var first_chunk=0;
                var last_chunk=0;

                $.each(arr,function(key,value){
                    var tmp_file_name=$("#"+tmp_file_name_id).val();
                    if(arr[key].length>0){
                        if(key==0){
                            first_chunk=1;
                        }else{
                            first_chunk=0;
                        }

                        if(key==arr.length-1){
                            last_chunk=1;
                        }
                        $.ajax({
                            type:"POST",
                            url:upload_route,
                            data: {
                                _token:csrf_token,
                                chunk: arr[key],
                                file_name:tmp_file_name,
                                first_chunk:first_chunk,
                                last_chunk:last_chunk,
                                'config_img_location':config_img_location,
                                ext:ext
                            },
                            async: false,
                            success: function (responce) {
                                var responce_obj=JSON.parse(responce);
                                $("#"+tmp_file_name_id).val(responce_obj.file_name);
                                $("#"+hidden_image_name_id).val(responce_obj.upload_file_name);
                                if(last_chunk==1){
                                    $("#"+tmp_file_name_id).val('');
                                }
                            }
                        });
                    }
                });
            }
        }
    };
}();