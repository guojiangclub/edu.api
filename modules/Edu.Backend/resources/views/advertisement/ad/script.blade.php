<script>
    $('#base-form').ajaxForm({
	    success: function (result) {
	    	if(result.status){
			    $("input[name='id']").val(result.data);
			    swal({
				    title: "保存成功！",
				    text: "",
				    type: "success"
			    }, function () {
				    location = '{{route('edu.ad.list')}}';
			    });
            } else {
			    swal("保存失败!", result.message, "error");
            }
	    }
    });
</script>