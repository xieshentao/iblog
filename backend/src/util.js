import $ from 'jquery';

export default{
    get(url, data, cb, token){
       let g = {
            method: 'GET',
            url: url,
            data: data,
            crossDomain: true,
            dataType: 'json',
            success: (data) => cb(data),
            error: (data) => cb(data)
        };
      if (token) {
            g.headers = {
                token: token,
            };
        }
        $.ajax(g);
    },
    post(url, data = {}, cb,token) {
        let g = {
            method: 'post',
            url: url,
            data: data,
            crossDomain: true,
            dataType: 'json',
            success: (data) => cb(data),
            error: (data) => cb(data)
        };
      if (token) {
        g.headers = {
          token: token,
        };
      }
      $.ajax(g);
    },
  getQueryVariable(variable)
  {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
      var pair = vars[i].split("=");
      if(pair[0] == variable){return pair[1];}
    }
    return(false);
  }
  }
