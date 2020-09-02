import $ from 'jquery';

export default{
    get(url, data, cb, needToken = 0) {
       let g = {
            method: 'GET',
            url: url,
            data: data,
            crossDomain: true,
            dataType: 'json',
            success: (data) => cb(data),
            error: (data) => cb(data)
        };
       if (needToken == 1) {
            g.headers = {
                'token': '123',
            };
        }
        $.ajax(g);
    },
    post(url, data = {}, cb,needToken = 0) {
        let g = {
            method: 'post',
            url: url,
            data: data,
            crossDomain: true,
            dataType: 'json',
            success: (data) => cb(data),
            error: (data) => cb(data)
        };
      if (needToken == 1) {
        g.headers = {
          'token': '123',
        };
      }
      $.ajax(g);
    },
}
