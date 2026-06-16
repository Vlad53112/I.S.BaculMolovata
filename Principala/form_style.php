<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0
}
body{
    font-family:'Segoe UI',Arial,sans-serif;
    background:#eef2f7;
    display:flex;
    justify-content:center;
    align-items:flex-start;
    min-height:100vh;
    padding:40px 16px
}
.container{
    background:#fff;
    border-radius:14px;
    padding:32px 36px;
    box-shadow:0 6px 24px rgba(0,0,0,.1);
    width:100%;
    max-width:460px
}
.back{
    display:inline-block;
    margin-bottom:18px;
    font-size:13px;
    color:#2980b9;
    text-decoration:none
}
.back:hover{
    text-decoration:underline
}
h2{
    font-size:20px;
    color:#1a3a6e;
    margin-bottom:24px;
    border-bottom:2px solid #eef2f7;
    padding-bottom:10px
}
label{
    display:block;
    font-size:13px;
    font-weight:600;
    color:#444;
    margin-bottom:5px;
    margin-top:14px
}
label:first-of-type{
    margin-top:0
}
input[type="text"],input[type="number"],input[type="date"],input[type="datetime-local"],
input[type="file"],textarea,select{
    width:100%;
    padding:10px 12px;
    border:1px solid #ccd;
    border-radius:7px;
    font-size:14px;
    transition:border-color .2s;
}
input:focus,textarea:focus,select:focus{
    outline:none;
    border-color:#2980b9
}
textarea{
    min-height:110px;
    resize:vertical
}
button[type="submit"]{
    width:100%;
    margin-top:22px;
    background:#1a3a6e;
    color:#fff;
    padding:12px;
    border:none;
    border-radius:8px;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
    transition:background .2s;
}
button[type="submit"]:hover{
    background:#2e5fbf
}
.error{
    color:#c0392b;
    font-size:13px;
    margin-top:4px
}
.opt{
    font-weight:400;
    color:#999
}
.existing{
    background:#f0f6ff;
    border:1px solid #c5d9f5;
    border-radius:6px;
    padding:8px 12px;
    font-size:13px;
    margin-top:6px
}
.existing a{
    color:#2980b9
}
#preview{
    max-width:100%;
    border-radius:7px;
    margin-top:8px;
    display:none;
    border:1px solid #ddd
}
</style>
