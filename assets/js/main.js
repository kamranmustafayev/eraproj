    let faded = 0
    $(document).on('click','.profilebut',function()
    {
        event.preventDefault()
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            $.ajax(
                {
                    type:'get',
                    url:'profile_ajax.php',
                    dataType:'html',
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
    })
    $(document).on('click','.goperson',function(e)
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            uid = e.target.id
            $.ajax(
                {
                    type:'get',
                    url:'personinfo_ajax.php?id='+uid,
                    data:{uid:uid},
                    dataType:'html',
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
        
    })
    $(document).on('click','.findbut',function()
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            finduser = document.getElementById('finduser').value
            $.ajax(
                {
                    type:'post',
                    url:'finduser_ajax.php',
                    data:{finduser:finduser},
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
        
    })
    $(document).on('click','.plikebut',function(e)
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            postid = e.target.id
            uid = document.getElementById('userid').value
            $.ajax(
                {
                    type:'post',
                    url:'personinfo_ajax.php?id='+uid,
                    data:{likbut:1,postid:postid},
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
    })
    $(document).on('click','.flikebut',function(e)
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            postid = e.target.id
            $.ajax(
                {
                    type:'post',
                    url:'main_ajax.php',
                    data:{likbut:1,postid:postid},
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
    })
    $(document).on('click','.fdislikebut',function(e)
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            postid = e.target.id
            $.ajax(
                {
                    type:'post',
                    url:'main_ajax.php',
                    data:{disbut:1,postid:postid},
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
    })
    $(document).on('click','.pdislikebut',function(e)
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            postid = e.target.id
            uid = document.getElementById('userid').value
            $.ajax(
                {
                    type:'post',
                    url:'personinfo_ajax.php?id='+uid,
                    data:{disbut:1,postid:postid},
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )    
        }
    })
    $(document).on('click','.goedit',function()
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            event.preventDefault()
            $.ajax(
                {
                    type:'get',
                    url:'settings_ajax.php',
                    dataType:'html',
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
    })
    $(document).on('click','.editbut',function()
	{
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            event.preventDefault()
            form = $('#editform')[0]
            data = new FormData(form)
            alert(data)
            $.ajax({
                type:'post',
                enctype:'multipart/form-data',
                url:'settings_ajax.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success:function(response)
                {
                    faded = 0
                    $('#data').html(response)
                },
            })
            }
    })
    $(document).on('click','.addfr',function()
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            uid = document.getElementById('userid').value
            $.ajax(
                {
                    type:'post',
                    url:'personinfo_ajax.php?id='+uid,
                    data:{addfrbut:1},
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )    
        }
    })
    $(document).on('click','.delfr',function()
    {
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            uid = document.getElementById('userid').value
            $.ajax(
                {
                    type:'post',
                    url:'personinfo_ajax.php?id='+uid,
                    data:{delfrbut:1},
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
    })
    $(document).on('click','.newpost',function()
    {
        event.preventDefault()
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            let tekst = document.getElementById("tekst").value
            uid = document.getElementById('userid').value
            document.getElementById("tekst").value = ""
            $.ajax(
                {
                    type:'post',
                    url:'personinfo_ajax.php?id='+uid,
                    data:{tekst:tekst},
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )    
        }
    })
    $(document).on('click','.gofriends',function()
    {
        event.preventDefault()
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            $.ajax(
                {
                    type:'get',
                    url:'friends_ajax.php',
                    dataType:'html',
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )    
        }
    })
    $(document).on('click','.mainbut',function()
    {
        event.preventDefault()
        if(faded == 0)
        {
            faded = 1
            $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
            $.ajax(
                {
                    type:'get',
                    url:'main_ajax.php',
                    dataType:'html',
                    success:function(response)
                    {
                        faded = 0
                        $('#data').html(response)
                    }
                }
            )
        }
        
    })
    $(document).ready(function()
    {
        $('#data').append('<div class="modal-backdrop fade show"><div class="spinner-border text-primary m-1" role="status"><span class="visually-hidden">Loading...</span></div></div>')
        $.ajax(
        {
            type:'get',
            url:'main_ajax.php',
            dataType:'html',
            success:function(response)
            {
                $('#data').html(response)
            }
        })
    })