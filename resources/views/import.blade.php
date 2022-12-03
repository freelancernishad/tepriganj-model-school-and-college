
<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,700,300);
body {
  font-family: "Lato", sans-serif;
}

.container {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  -webkit-box-align: center;
  -moz-box-align: center;
  box-align: center;
  -webkit-align-items: center;
  -moz-align-items: center;
  -ms-align-items: center;
  -o-align-items: center;
  align-items: center;
  -ms-flex-align: center;
  display: -webkit-box;
  display: -moz-box;
  display: box;
  display: -webkit-flex;
  display: -moz-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
  -moz-box-pack: center;
  box-pack: center;
  -webkit-justify-content: center;
  -moz-justify-content: center;
  -ms-justify-content: center;
  -o-justify-content: center;
  justify-content: center;
  -ms-flex-pack: center;
  background-color: #bf7a6b;
  background-image: -webkit-linear-gradient(bottom left, #bf7a6b 0%, #e6d8a7 100%);
  background-image: linear-gradient(to top right,#bf7a6b 0%, #e6d8a7 100%);
}

.form {
  width: 400px;
}

.file-upload-wrapper {
  position: relative;
  width: 100%;
  height: 60px;
}
.file-upload-wrapper:after {
  content: attr(data-text);
  font-size: 18px;
  position: absolute;
  top: 0;
  left: 0;
  background: #fff;
  padding: 10px 15px;
  display: block;
  width: calc(100% - 40px);
  pointer-events: none;
  z-index: 20;
  height: 40px;
  line-height: 40px;
  color: #999;
  border-radius: 5px 10px 10px 5px;
  font-weight: 300;
}
.file-upload-wrapper:before {
  content: "Upload";
  position: absolute;
  top: 0;
  right: 0;
  display: inline-block;
  height: 60px;
  background: #4daf7c;
  color: #fff;
  font-weight: 700;
  z-index: 25;
  font-size: 16px;
  line-height: 60px;
  padding: 0 15px;
  text-transform: uppercase;
  pointer-events: none;
  border-radius: 0 5px 5px 0;
}
.file-upload-wrapper:hover:before {
  background: #3d8c63;
}
.file-upload-wrapper input {
  opacity: 0;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 99;
  height: 40px;
  margin: 0;
  padding: 0;
  display: block;
  cursor: pointer;
  width: 100%;
}

</style>

<div class="container">
    <form class="form" action="/dashboard/import" method="POST" enctype="multipart/form-data">
        @csrf
      {{-- <div class="file-upload-wrapper" data-text="Select your file!">
        <input name="ecelfile" type="file" class="file-upload-field" >
      </div> --}}
      <input name="ecelfile" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  >

      <button type="submit" class="btn btn-success" style="    background: #ff5200;
      padding: 12px;
      width: 100%;
      margin-top: 20px;
      font-size: 25px;
      border: 0 !important;
      cursor: pointer;
      color: white;">Import</button>

    </form>
  </div>
