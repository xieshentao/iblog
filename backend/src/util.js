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
  }
