var input_type_submit = '';
var button_type_submit = '';
var rowid = '';
var delete_btn = '';
var delete_id = '';
var delete_url = '';

var block_btn = '';
var block_id = '';
var block_url = '';

var listcheckbox = [];
var search_input = '';
var fid = '';
var status = '';

$(document).on("click", ".password_show_hide",(function(e) {
  this_btn = $(this);
  input_field = $(this_btn).parent().find('input');
  if($(input_field).attr("type")=='password')
  {
    $(input_field).attr("type","text");
    $(this_btn).removeClass('fa-eye')    
    $(this_btn).addClass('fa-eye-slash')    
  }
  else
  {
    $(input_field).attr("type","password");    
    $(this_btn).removeClass('fa-eye-slash')    
    $(this_btn).addClass('fa-eye')    
  }
}));

function success_message(text)
{
  saberToast.success({
        title: "Success", 
        text: text,
        delay: 200,
        duration: 2600,
        rtl: true,
        position: "top-left"
    });
}
function error_message(text)
{
    saberToast.error({
        title: "Warning",
        text: text,
        delay: 200,
        duration: 2600,
        rtl: true,
        position: "top-left"
    });
}

function loader(type)
{
  var html = `
      <div class="my-loader">
        <div>
          <div class="load-wrapp">
            <div class="load-6">
              <div class="letter-holder">
                <div class="l-1 letter">L</div>
                <div class="l-2 letter">o</div>
                <div class="l-3 letter">a</div>
                <div class="l-4 letter">d</div>
                <div class="l-5 letter">i</div>
                <div class="l-6 letter">n</div>
                <div class="l-7 letter">g</div>
                <div class="l-8 letter">.</div>
                <div class="l-9 letter">.</div>
                <div class="l-10 letter">.</div>
              </div>
            </div>
          </div>
          <div class="progress-div">
            <div id="progressWrapper">
                <div id="progressBar" style="width: 0%; height: 20px; background-color: green;border-radius: 20px;"></div>
            </div>
            <div id="progressText">0%</div>
          </div>

        </div>


      </div>`;
  if(type=='show') $('body').prepend(html);
  else $('.my-loader').remove();
}
function data_loader(id,type)
{
  var html = `
      <div class="my-loader my-loader2">
        <div class="load-wrapp">
          <div class="load-6">
            <div class="letter-holder">
              <div class="l-1 letter">L</div>
              <div class="l-2 letter">o</div>
              <div class="l-3 letter">a</div>
              <div class="l-4 letter">d</div>
              <div class="l-5 letter">i</div>
              <div class="l-6 letter">n</div>
              <div class="l-7 letter">g</div>
              <div class="l-8 letter">.</div>
              <div class="l-9 letter">.</div>
              <div class="l-10 letter">.</div>
            </div>
          </div>
        </div>
      </div>`;
  if(type==1) $(id).append(html);
  else $(".my-loader2").remove();
}
function input_loader(id,type)
{
  $(".input-load").remove()
  var html = `      
        <div class="input-load">
          <div class="load-6">
            <div class="letter-holder">
              <div class="l-1 letter">L</div>
              <div class="l-2 letter">o</div>
              <div class="l-3 letter">a</div>
              <div class="l-4 letter">d</div>
              <div class="l-5 letter">i</div>
              <div class="l-6 letter">n</div>
              <div class="l-7 letter">g</div>
              <div class="l-8 letter">.</div>
              <div class="l-9 letter">.</div>
              <div class="l-10 letter">.</div>
            </div>
          </div>
        </div>
      `;
  if(type==1) $(id).after(html);
  else $(".input-load").remove();
}
function print_input_search_success_error(search_input,message,type)
{
  if(type==1)
  {
    var html = `
      <div class="alert alert-success alert-dismissible alert-label-icon rounded-label fade show material-shadow" role="alert">
          <i class="fa fa-check-double label-icon"></i>
          <strong>Success</strong> - ${message}
      </div>
    `;
  }
  else
  {
    var html = `
      <div class="alert alert-warning alert-dismissible alert-label-icon rounded-label fade show material-shadow" role="alert">
          <i class="fa label-icon">&#xf071;</i><strong>Warning</strong> - ${message}
      </div>
    `;
  }
  $(search_input).parent().find(".alert").remove();
  $(search_input).after(html);

}




function setCookie(name, value) {
  const expires = new Date();
  expires.setFullYear(expires.getFullYear() + 100); // 100 years from now
  document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires.toUTCString()}; path=/`;
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

let uniqueId = getCookie('unique_id');


if (!uniqueId) {
  uniqueId = 'id_' + Date.now() + '_' + Math.floor(Math.random() * 100000);
  setCookie('unique_id', uniqueId);
  console.log('Unique ID set for lifetime:', uniqueId);
} else {
  console.log('Existing Unique ID:', uniqueId);
}





function print_toast(message,type)
{
  const bottomRightContainer = document.createElement('div')
    bottomRightContainer.classList.add('custom-tost')
    document.body.append(bottomRightContainer)
    $(".custom-tost").html('<span>'+message+'</span>');
    $(".custom-tost").fadeIn();
    setTimeout(function(){ 
      $(".custom-tost").fadeOut();
     }, 2000);
    setTimeout(function(){ 
      $(bottomRightContainer).remove();
     }, 3000);
}




// data submit form
var form = '';
      $(document).on("submit", ".form_data",(function(e) {
        event.preventDefault();

        form = $(this);
        fid = form.attr('id');
         var submitInputs = form.find("input[type='submit']");
        var submitButtons = form.find("button[type='submit']");

        

        var form_ok = 1;
        $(form.find("input")).each(function(){
           var input = $(this).prop("required"); 
           if (input == true)
           {
              if ($(this).val()=="")
              {              
                form_ok = 0;
                var placeholder = $(this).attr("placeholder");
                if (placeholder==undefined) placeholder = $(this).attr("name");
                $(this).next('.invalid-feedback').remove();
                $(this).after('<div class="invalid-feedback">Please provide a valid text.</div>');  
                $(this).addClass("is-invalid");
                // $(this).addClass("focus-red");
                $(this).focus();
                return false;
              }
              else 
              {
                $(this).removeClass("is-invalid");
                $(this).next('.invalid-feedback').remove();
               form_ok = 1;
              }
            }
        });
        if (form_ok==1)
        {
          $(input_type_submit).attr("disabled",true);
          $(button_type_submit).attr("disabled",true);
          
          loader('show');

          var url1 = form.attr('action');
          var formDtataNew = new FormData(this);
          formDtataNew.append("lat", localStorage.getItem("lat"));
          formDtataNew.append("long", localStorage.getItem("long"));
          formDtataNew.append("uniqueId", uniqueId);

          $.ajax({
           url: url1,
           type: "POST",
           data:  formDtataNew,
           dataType:"json",
           "headers": {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
           },
           contentType: false,
                 cache: false,
           processData:false,
           xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $('#progressBar').css('width', percentComplete + '%');
                        $('#progressText').text(percentComplete + '%');
                    }
                }, false);
                return xhr;
             },
           success: function(result)
              {
                  admin_response_data_check(result);
              },
              error: function(e) 
              {
                admin_response_data_check(e);
              }          
            }); 
        }
      }));
      $(document).on("click", ".submit-btn",(function(e) {
        e.preventDefault();
        var id = $(this).data("target");  
        // $("#"+id).trigger("submit");
         input_type_submit = $("#"+id+" input[type='submit']").trigger('click');
         button_type_submit = $("#"+id+" button[type='submit']").trigger('click');
      }));

      function admin_response_data_check(result)
      {
        console.log(result);
       
        if(input_type_submit)
        {
          $(input_type_submit).attr("disabled",false);
          $(button_type_submit).attr("disabled",false);
        }
        if(result.status==200)
        {          
          if(result.action=="add")
          { 
            success_message(result.message);
            loader('hide');
            $(form)[0].reset();
            // $("#"+fid)[0].reset();
            // $('#'+fid+' .images-ul').empty();
            if($("select")) $("select").select2();
            // $("select").select2();
          }
          else if(result.action=="login")
          { 
            success_message(result.message);
            loader('hide');
            console.log(result.data.loginid);
            localStorage.setItem("loginid",result.data.loginid);
            window.location.href=result.url;
          }
          else if(result.action=="redirect")
          { 
            success_message(result.message);
            loader('hide');
            window.location.href=result.url;
          }
          else if(result.action=="reload")
          { 
            success_message(result.message);
            loader('hide');
            location.reload();
          }
          else if(result.action=="delete")
          { 
            success_message(result.message);
            loader('hide');
            $('#deleteConfirm').modal('hide'); 
            $(delete_btn).closest("tr").remove();
          }
          else if(result.action=="statusChange")
          { 
            success_message(result.message);
            loader('hide');
            $('#accountBlock').modal('hide'); 
            $(block_btn).closest("tr").remove();
          }
          else if(result.action=="approvereject")
          { 
            success_message(result.message);
            loader('hide');
            $('#approveBlock').modal('hide'); 
            $(block_btn).closest("tr").remove();
          }
          else if(result.action=="check_login")
          {
            window.location.href=result.url; 
            return result;
          }
          else if(result.action=="view" || result.action=="search" || result.action=="modalform" || result.action=="videodata" || result.action=="exportdata" || result.action=="calendar" || result.action=="viewJson")
          { 
              return result;
          }
          else if(result.action=="loadTable")
          { 
            success_message(result.message);
            loader('hide');
            $('#accountBlock').modal('hide'); 
            get_url_data();
            url = main_url+'?'+data;
            load_table();
          }
          else if(result.action=="modalsubmitadd")
          {
            $("#"+result.modalid).modal("hide");
            $(form)[0].reset();
            success_message(result.message);
            loader('hide');
          }
          else if(result.action=="mainmodalsubmitadd")
          {
            localStorage.setItem("mainModal",true);
            $("#"+result.modalid).modal("hide");
            $(form)[0].reset();
            success_message(result.message);
            loader('hide');
          }
          else if(result.action=="modalsubmitedit")
          {
            $("#"+result.modalid).modal("hide");
            success_message(result.message);
            loader('hide');
          }
          else
          {
            success_message(result.message);
            loader('hide');
          }
        }
        else
        {
          if(result.responseJSON) result = result.responseJSON;          
          if(result.status==400)
          {
              loader('hide');
            if(result.action=="login")
            { 
              success_message(result.message);
              loader('hide');
              localStorage.setItem("loginid",0);
            }
            else if(result.action=="edit")
            { 
              error_message(result.message);
            }
            else if(result.action=="add")
            { 
              error_message(result.message);
            }
            else if(result.action=="check_login")
            { 
              return result;
            }
            else if(result.action=="view" || result.action=="search" || result.action=="modalform" || result.action=="videodata" || result.action=="exportdata" || result.action=="calendar" || result.action=="viewJson")
            { 
                return result;
            }
            else if(result.action=="modalsubmit")
            {
              success_message(result.message);
              loader('hide');
            }
            else
            {
              success_message(result.message);
              loader('hide');
            }
          }
          else if(result.status==401)
          {
            loader('hide');
            error_message(result.message);
          }
          else if(result.status==419)
          {
            loader('hide');
            location.reload();
          }
          else
          {
            if(!result.statusText)
            {
              if(result.message=='CSRF token mismatch.')
              {
                location.reload();
              }
            }
            loader('hide');
            error_message(result.statusText);
          }
        }
      }


// data form end



// delte button
$(document).on("click", ".remove-item-btn",(function(e) {  
  event.preventDefault();
  $('#deleteConfirm').modal('show');  
  delete_id = $(this).data("id");  
  delete_url = $(this).attr('href');
  delete_btn = $(this);
}));
$(document).on("click", ".delete-ok",(function(e) {      
  $(".loading").addClass("active");
  rowid = "rowno";
  $.ajax({
        url:delete_url,
        type:"post",
        data:{id:delete_id,rowid:rowid},
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        success: function(result)
          {
              admin_response_data_check(result);
          },
          error: function(e) 
          {
            admin_response_data_check(e);
          } 
    });      
}));
// delete button end


// block/unblock button
$(document).on("click", ".block-item-btn",(function(e) {  
  event.preventDefault();
  block_url = $(this).attr('href');
  block_btn = $(this);
  status = $(this).val();
  if(status==undefined || status=='')
  {
    status = $(this).data('value');
  }

  $("#accountBlockBodyDisable, #accountBlockBodyEnable").hide();
  if(status==1) $("#accountBlockBodyDisable").show();
  if(status==0) $("#accountBlockBodyEnable").show();


  $('#accountBlock').modal('show');
}));
$(document).on("click", ".block-ok",(function(e) {      
  $(".loading").addClass("active");
  $.ajax({
        url:block_url,
        type:"post",
        data:{status:status},
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        success: function(result)
          {
              admin_response_data_check(result);
          },
          error: function(e) 
          {
            admin_response_data_check(e);
          } 
    });      
}));
// block/unblock button end





// status-change/unblock button
$(document).on("click", ".status-change-item-btn",(function(e) {  
  event.preventDefault();
  block_url = $(this).data('url');
  block_btn = $(this);
  status = 0;
  if($(this).prop('checked') == true)
  {
    status = 1;
  }

  $("#accountBlockBodyDisable, #accountBlockBodyEnable").hide();
  if(status==0) $("#accountBlockBodyDisable").show();
  if(status==1) $("#accountBlockBodyEnable").show();


  $('#accountBlock').modal('show');
}));
$(document).on("click", ".status-change-ok",(function(e) {      
  $(".loading").addClass("active");
  $.ajax({
        url:block_url,
        type:"post",
        data:{status:status},
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        success: function(result)
          {
              admin_response_data_check(result);
          },
          error: function(e) 
          {
            admin_response_data_check(e);
          } 
    });      
}));
// status-change/unblock button end





$(document).on('click',".status_change",function (e) {
  $(".loading").addClass("active");
  var id = $(this).val();
  var url = $(this).data("url");
  var column = $(this).data("column");
  if ($(this).prop('checked')==true)
    var status = 1;
  else
    var status = 0;

  $.ajax({
      url:url,
      type:"post",
      data:{id:id,status:status,column:column},
      success:function(d)
      {
        console.log(column);
        var result = JSON.parse(d);
        if(result.status=="200")
        {
          success_message(result.message);
          $("#"+column+id).html(result.data['status']);
        }
        else if(result.status=="400")
        {
          error_message(result.message);
        }
          $(".loading").removeClass("active");       
      },
      error: function(e) 
    {
      $(".loading").removeClass("active");
    } 
  });
});







function deleteAllCookies() {
    const cookies = document.cookie.split(";");

    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}



 

  

$(document).on("click", ".open-pdf",(function(e) {
  var id = $(this).attr("id");
  var url2 = window.location.hostname;
  var url = window.location.pathname;
  var url = "http://".concat(url2, url, "content/", id);
  window.open(url, "", "width=800,height=500");
}));


$(document).on("click", ".open-docx",(function(e) {
  event.preventDefault();
  var id = $(this).attr("id");
  var url2 = window.location.hostname;
  var url = window.location.pathname;
  var url = "http://".concat(url2, url, "content/", id);
  var url = "https://view.officeapps.live.com/op/embed.aspx?src=" + url;
  window.open(url, "", "width=800,height=500");
}));





function check_required_fields(form_id)
{
  var form_ok = 1;
  fid = form_id;
  $("#"+form_id+" :input").each(function(){
         var input = $(this).prop("required"); 
         if (input == true)
         {
            if ($(this).val()=="" || $(this).val()=="0")
            {
              form_ok = 0;
              var placeholder = $(this).attr("placeholder");
              if (placeholder==undefined) placeholder = $(this).attr("name");
              $(this).next('p').remove();
              $(this).after('<p class="error" >This field is required.</p>');  
              $(this).addClass("is-invalid");
              $(this).focus();
              return false;
            }
            else 
            {
              $(this).removeClass("is-invalid");
              $(this).next('.invalid-feedback').remove();
              $(this).next('.error').remove();
             form_ok = 1;
            }
          }
        });
  return form_ok;
}



function check_login()
{
  var loginid = localStorage.getItem('loginid');
  var base_url = $('meta[name="base_url"]').attr('content')
  if(loginid)
  {
    $.ajax({
        url:base_url+'check_login',
        type:"post",
        data:{loginid:loginid},
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        success: function(result)
          {
              admin_response_data_check(result);
          },
          error: function(e) 
          {
            admin_response_data_check(e);
          } 
    });
  }
  else
  {

  }
}




