function init() {
    var myNodelist = document.getElementsByTagName("LI");
    var i;
    for (i = 0; i < myNodelist.length; i++) {
      var span = document.createElement("SPAN");
      var txt = document.createTextNode("\u00D7");
      span.className = "close";
      span.appendChild(txt);
      myNodelist[i].appendChild(span);
    }

    var close = document.getElementsByClassName("close");
    var i;
    for (i = 0; i < close.length; i++) {
      close[i].onclick = function() {
        document.getElementById('operation').value = 'del';
        document.getElementById('myInput').value = this.parentNode.getAttribute('data-name');
        document.getElementById('myDIV').submit();
      }
    }

    var list = document.querySelector('ul');
    list.addEventListener('click', function(ev) {
      if (ev.target.tagName === 'LI') {
        document.getElementById('operation').value = 'check';
        document.getElementById('myInput').value = ev.target.getAttribute('data-name');
        document.getElementById('myDIV').submit();
      }
    }, false);
  }
  init();