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
