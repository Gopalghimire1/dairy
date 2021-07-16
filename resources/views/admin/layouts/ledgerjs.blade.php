<script >
    var win={
        id:"#window",
        shown:false,
        show:(title,text)=>{
            $('#wt').html(title);
            $('#wc').html(text);
            $(win.id).addClass('shown');
            win.shown=true;
            console.log(win);
        },
        showGet:(title,URL)=>{
            $('#wt').html(title);
            axios.get(URL)
            .then((res)=>{
                $('#wc').html(res.data);
                $(win.id).addClass('shown');
                win.shown=true;
            });

            console.log(win);
        },
        showPost:(title,URL,data)=>{
            $('#wt').html(title);
            data._token="{{ csrf_token() }}";
            axios.post(URL,data)
            .then((res)=>{
                $('#wc').html(res.data);
                $(win.id).addClass('shown');
                win.shown=true;
            });

            console.log(win);
        },
        hide:()=>{
            $('#wc').html("");
            $(win.id).removeClass('shown');
            win.shown=false;
            console.log(win);
        }
    };
    lock=false;
    function initEditLedger(title, id){
        win.showPost("Edit Ledger - "+title,"{{route('ledger1.edit')}}",{"id":id});
    }

    function s_calculate(){
        $('#s_amount').val($('#s_rate').val()*$('#s_qty').val());
    }

    function updateLedger(){
        if(!lock){
            if(confirm('Do You Want TO Update Ledger ')){

                data=new FormData(document.getElementById('xp_1'));
                lock=true;
                axios.post("{{route('ledger1.update')}}",data)
                .then(function(response){
                    console.log(response);
                    lock=false;
                    win.hide();
                    loadData();
                })
                .catch(function(err){
                    lock=false;
                    alert('Ledger Cannot be Updated');
                })
            }
        }
    }

    function deleteLedger(id,callback=null){
        if(!lock){
            if(confirm('Do You Want To Delete Ledger ')){

                data={"id":id};
                lock=true;
                axios.post("{{route('ledger1.del')}}",data)
                .then(function(response){
                    lock=false;
                    if (callback && typeof(callback) === "function") {
                        callback(id);
                    }
                })
                .catch(function(err){
                    lock=false;
                    alert('Ledger Cannot be Updated');
                })
            }
        }
    }


</script>
