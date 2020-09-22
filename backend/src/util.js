import $ from 'jquery';

export default {
  get(url, data, cb, token = null) {
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
  post(url, data = {}, cb, token = null) {
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
  getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
      var pair = vars[i].split("=");
      if (pair[0] == variable) {
        return pair[1];
      }
    }
    return (false);
  },
  randomNum(minNum, maxNum) {
    switch (arguments.length) {
      case 1:
        return parseInt(Math.random() * minNum + 1, 10);
        break;
      case 2:
        return parseInt(Math.random() * (maxNum - minNum + 1) + minNum, 10);
        //或者 Math.floor(Math.random()*( maxNum - minNum + 1 ) + minNum );
        break;
      default:
        return 0;
        break;
    }
  }
}
