$(document).ready(function() {
    console.log(base_url)

      $(document).on('click','.addTask',function(){
        let task = $('#task').val();
        $.ajax({
            url: base_url+'/task',
            method: 'POST',
            data: {
                task: task,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    $("#taskResponse").html("<p class='alert alert-success alert-dismissible fade show'>Task successfully added.</p>");
                    fetchAllTask();
                }else{
                    $("#taskResponse").html('<p class=	"alert alert-danger alert-dismissible fade show">'+response.error+'</p>');
                }
            }
        });
      });

    $(document).on('click', '.completeTask', function() {
        
        let taskId = $(this).attr('id');
        $.ajax({
            url: base_url+"/tasks/"+taskId,
            type: 'PATCH',
            data: { taskId:taskId },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success){
                    $(".completeBtn_"+taskId).hide();
                    $("#tsk_status_"+taskId).text('Done');
                    $("#taskResponse").html('<p class=	"alert alert-success alert-dismissible fade show">'+response.msg+'</p>');
                }else{
                    $("#taskResponse").html('<p class=	"alert alert-danger alert-dismissible fade show">'+response.msg+'</p>');
                }
            }
        });
    });

    $(document).on('click', '.deleteTask', function() {
        let taskId = $(this).attr('id');
        console.log(taskId);
        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: base_url+"/tasks/"+taskId,
                type: 'DELETE',
                data: {  },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $("#taskResponse").html('<p class=	"alert alert-success alert-dismissible fade show">'+response.msg+'</p>');
                        fetchAllTask();
                    }else{
                        $("#taskResponse").html('<p class=	"alert alert-danger alert-dismissible fade show">'+response.msg+'</p>');
                    }
                    
                }
            });
        }
    });

    function fetchAllTask(){
        $.ajax({
            url: base_url,
            method: 'GET',
            success: function(response) {
                console.log(response);
                $('#taskList').empty();
                $(response).each(function(index, val) {
                    console.log(val.id);
                    let taskStatus = '';
                    let completBtn = '<button class="btn btn-success completeTask completeBtn_'+val.id+'" id='+val.id+'><i class="fa fa-check"></i></button>';
                    if(val.completed == 1){
                        taskStatus = "Done";
                        completBtn = "";
                    }
                    $('#taskList').append('<tr><td>'+val.id+'</td><td>'+val.task+'</td><td id="tsk_status_'+val.id+'">'+taskStatus+'</td><td class="btn-action">'+completBtn+' <button class="btn btn-danger deleteTask" id='+val.id+'><i class="fa fa-close"></i></button></td></tr>');
                });
                
            }
        });
    }

    $('.showAllTask').click(function() {
        fetchAllTask();
        
    });
});