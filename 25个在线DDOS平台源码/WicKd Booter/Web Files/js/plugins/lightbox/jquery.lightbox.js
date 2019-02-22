/*!
 * jQuery Lightbox Evolution - for jQuery 1.3+
 * http://codecanyon.net/item/jquery-lightbox-evolution/115655?ref=aeroalquimia
 *
 * Copyright (c) 2010, Eduardo Daniel Sada
 * Released under CodeCanyon Regular License.
 * http://codecanyon.net/licenses/regular_extended
 *
 * Version: 1.6.8 (July 05 2012)
 *
 * Includes jQuery Easing v1.3
 * http://gsgd.co.uk/sandbox/jquery/easing/
 * Copyright (c) 2008, George McGinley Smith
 * Released under BSD License.
 */

;(function($, window, document, undefined)
{
  var usearch       = (function(u) {return function() {return u.search(arguments[0]);};})((navigator && navigator.userAgent) ? navigator.userAgent.toLowerCase() : "");
  var is_ie6        = ($.browser.msie && parseInt($.browser.version, 10) < 7 && parseInt($.browser.version, 10) > 4);
  var is_smartphone = false;

  // detect android;
  if (usearch("mobile") > -1)
  {
    if (usearch("android") > -1 || usearch("googletv") > -1 || usearch("htc_flyer") > -1)
    {
      is_smartphone = true;
    }
  };

  // detect opera mini and mobile;
  if (usearch("opera") > -1)
  {
    if (usearch("mini") > -1 && usearch("mobi") > -1)
    {
      is_smartphone = true;
    }
  };

  // detect iOS;
  if (usearch("iphone") > -1)
  {
    is_smartphone = true;
  };

  // detect windows 7 phones;
  if (usearch("windows phone os 7") > -1)
  {
    is_smartphone = true;
  };

  // for jQuery 1.3;
  if ($.proxy === undefined)
  {
    var class2type = {};
    $.each(["Boolean", "Number", "String", "Function", "Array", "Date", "RegExp", "Object"], function(i, name)
    {
      class2type["[object " + name + "]"] = name.toLowerCase();
    });

    $.extend({
      proxy: function(fn, thisObject)
      {
        if (fn)
        {
          return function() {return fn.apply(thisObject || this, arguments);};
        }
      },
      type: function(obj)
      {
        return obj === null ? String(obj) : class2type[Object.prototype.toString.call(obj)] || "object";
      },
      parseJSON: function(data)
      {
        if (typeof data !== "string" || !data)
        {
          return null;
        }    

        data = $.trim(data);

        if (/^[\],:{}\s]*$/.test(data.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@")
        .replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]")
        .replace(/(?:^|:|,)(?:\s*\[)+/g, "")))
        {
          return window.JSON && window.JSON.parse ? window.JSON.parse(data) : (new Function("return " + data))();
        }
        else
        {
          alert("Invalid JSON: " + data);
        }
      }
    });
  };
    
  // for jQuery 1.3;
  $.extend($.fx.prototype, {
    update: function()
    {
      if (this.options.step)
      {
        this.options.step.call(this.elem, this.now, this);
      }
      ($.fx.step[this.prop] || $.fx.step._default)(this);
    }
  });
	
  // jQuery Easing v1.3;
  $.extend($.easing, {
    easeOutBack: function (x, t, b, c, d, s)
    {
      if (s === undefined) s = 1.70158;
      return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
    }
  });

  $.extend({
    LightBoxObject: {
      defaults: {
        name  : 'jquery-lightbox',
        style : {
          zIndex : 99999,
          width  : 470,
          height : 280
        },
        modal    : false,
        overlay  : {
          opacity: 0.6
        },
        animation: {
          show: {
            duration: 400,
            easing  : "easeOutBack"
          },
          close: {
            duration: 200,
            easing  : "easeOutBack"
          },
          move: {
            duration: 800,
            easing  : "easeOutBack"
          },
          shake: {
            duration : 100,
            easing   : "easeOutBack",
            distance : 10,
            loops    : 2
          }
        },
        flash        : {
          width  : 640,
          height : 360
        },
        iframe       : {
          width  : 640,
          height : 360
        },
        maxsize  : {
          width  : -1,
          height : -1
        },
        emergefrom   : "top",
        ajax         : {
          type     : "GET",
          cache    : false,
          dataType : "html"
        }
      },
      options     : {},
      animations  : {},
      gallery     : {},
      image       : {},
      esqueleto   : {
        lightbox    : [],
        buttons     : {
          close     : [],
          prev      : [],
          max       : [],
          next      : []
        },
        background  : [],
        image       : [],
        title       : [],
        html        : []
      },
      matchedlnks : [],
      visible     : false,
      maximized   : false,
      mode        : "image",
      videoregs   : {
        swf: {
          reg: /[^\.]\.(swf)\s*$/i
        },
        youtube: {
          reg: /youtube\.com\/watch/i,
          split: '=',
          index: 1,
          iframe: 1,
          url: "http://www.youtube.com/embed/%id%?autoplay=1&amp;fs=1&amp;rel=0&amp;enablejsapi=1"
        },
        youtu: {
          reg: /youtu\.be\//i,
          split: '/',
          index: 3,
          iframe: 1,
          url: "http://www.youtube.com/embed/%id%?autoplay=1&amp;fs=1&amp;rel=0&amp;enablejsapi=1"
        },
        metacafe: {
          reg: /metacafe\.com\/watch/i,
          split: '/',
          index: 4,
          url: "http://www.metacafe.com/fplayer/%id%/.swf?playerVars=autoPlay=yes"
        },
        dailymotion: {
          reg: /dailymotion\.com\/video/i,
          split: '/',
          index: 4,
          url: "http://www.dailymotion.com/swf/video/%id%?additionalInfos=0&amp;autoStart=1"
        },
        google: {
          reg: /google\.com\/videoplay/i,
          split: '=',
          index: 1,
          url: "http://video.google.com/googleplayer.swf?autoplay=1&amp;hl=en&amp;docId=%id%"
        },
        vimeo: {
          reg: /vimeo\.com/i,
          split: '/',
          index: 3,
          iframe: 1,
          url: "http://player.vimeo.com/video/%id%?hd=1&amp;autoplay=1&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1"
        },
        gametrailers: {
          reg: /gametrailers\.com/i,
          split: '/',
          index: 5,
          url: "http://www.gametrailers.com/remote_wrap.php?mid=%id%"
        },
        collegehumornew: {
          reg: /collegehumor\.com\/video\//i,
          split: 'video/',
          index: 1,
          url: "http://www.collegehumor.com/moogaloop/moogaloop.jukebox.swf?autostart=true&amp;fullscreen=1&amp;use_node_id=true&amp;clip_id=%id%"
        },
        collegehumor: {
          reg: /collegehumor\.com\/video:/i,
          split: 'video:',
          index: 1,
          url: "http://www.collegehumor.com/moogaloop/moogaloop.swf?autoplay=true&amp;fullscreen=1&amp;clip_id=%id%"
        },
        ustream: {
          reg: /ustream\.tv/i,
          split: '/',
          index: 4,
          url: "http://www.ustream.tv/flash/video/%id%?loc=%2F&amp;autoplay=true&amp;vid=%id%&amp;disabledComment=true&amp;beginPercent=0.5331&amp;endPercent=0.6292&amp;locale=en_US"
        },
        twitvid: {
          reg: /twitvid\.com/i,
          split: '/',
          index: 3,
          url: "http://www.twitvid.com/player/%id%"
        },
        wordpress: {
          reg: /v\.wordpress\.com/i,
          split: '/',
          index: 3,
          url: "http://s0.videopress.com/player.swf?guid=%id%&amp;v=1.01"
        },
        vzaar: {
          reg: /vzaar\.com\/videos/i,
          split: '/',
          index: 4,
          url: "http://view.vzaar.com/%id%.flashplayer?autoplay=true&amp;border=none"
        }
      },
      
      mapsreg: {
        bing: {
          reg: /bing\.com\/maps/i,
          split: '?',
          index: 1,
          url: "http://www.bing.com/maps/embed/?emid=3ede2bc8-227d-8fec-d84a-00b6ff19b1cb&amp;w=%width%&amp;h=%height%&amp;%id%"
        },
        streetview: {
          reg: /maps\.google\.com(.*)layer=c/i,
          split: '?',
          index: 1,
          url: "http://maps.google.com/?output=svembed&amp;%id%"
        },
        googlev2: {
          reg: /maps\.google\.com\/maps\/ms/i,
          split: '?',
          index: 1,
          url: "http://maps.google.com/maps/ms?output=embed&amp;%id%"
        },
        google: {
          reg: /maps\.google\.com/i,
          split: '?',
          index: 1,
          url: "http://maps.google.com/maps?%id%&amp;output=embed"
        }
      },
      
      imgsreg: /\.(jpg|jpeg|gif|png|bmp|tiff)(.*)?$/i,
      
      overlay : {
        create: function(options) {
          this.options = options;
          this.element = $('<div id="'+new Date().getTime()+'" class="'+this.options.name+'-overlay"></div>');
          this.element.css($.extend({}, {
            'position'  : 'fixed',
            'top'       : 0,
            'left'      : 0,
            'opacity'   : 0,
            'display'   : 'none',
            'z-index'   : this.options.zIndex
          }, this.options.style));

          this.element.click($.proxy(function(e) {
            if (!this.options.modal)
            {
              if ($.isFunction(this.options.callback))
              {
                this.options.callback();
              }
              else
              {
                this.hide();
              }
            }
            e.preventDefault();
          }, this));
          
          this.hidden = true;
          this.inject();
          return this;
        },

        inject: function() {
          this.target = $(document.body);
          this.target.append(this.element);

          if (is_ie6)
          {
            this.element.css('position', 'absolute');
            var zIndex = parseInt(this.element.css('zIndex'), 10);
            if (!zIndex)
            {
              zIndex = 1;
              var pos = this.element.css('position');
              if (pos === 'static' || !pos)
              {
                this.element.css('position', 'relative');
              }
              this.element.css('zIndex', zIndex);
            }

            zIndex = (!!(this.options.zIndex || this.options.zIndex === 0) && zIndex > this.options.zIndex) ? this.options.zIndex : zIndex - 1;
            if (zIndex < 0)
            {
              zIndex = 1;
            }

            this.shim = $('<iframe id="IF_'+new Date().getTime()+'" scrolling="no" frameborder=0 src=""></iframe>');
            this.shim.css({
              zIndex    : zIndex,
              position  : 'absolute',
              top       : 0,
              left      : 0,
              border    : 'none',
              width     : 0,
              height    : 0,
              opacity   : 0
            });

            this.shim.insertAfter(this.element);
            $('html, body').css({
              'height'      : '100%',
              'width'       : '100%',
              'margin-left' : 0,
              'margin-right': 0
            });
          }
        },

        resize: function(x, y) {
          this.element.css({ 'height': 0, 'width': 0 });
          if (this.shim) { this.shim.css({ 'height': 0, 'width': 0 }); };

          var win = { x: $(document).width(), y: $(document).height() };
          
          this.element.css({
            'width'   : '100%',
            'height'  : y || win.y
          });
          
          if (this.shim)
          {
            this.shim.css({ 'height': 0, 'width': 0 });
            this.shim.css({
              'position': 'absolute',
              'left'    : 0,
              'top'     : 0,
              'width'   : this.element.width(),
              'height'  : y || win.y
            });
          }
          return this;
        },

        show: function(callback) {
          if (!this.hidden) { return this; };
          if (this.transition) { this.transition.stop(); };
          if (this.shim) { this.shim.css('display', 'block'); };
          this.element.css({'display':'block', 'opacity':0});

          this.target.bind('resize', $.proxy(this.resize, this));
          this.resize();
          this.hidden = false;

          this.transition = this.element.fadeTo(this.options.showDuration, this.options.style.opacity, $.proxy(function(){
            if (this.options.style.opacity) { this.element.css(this.options.style) };
            this.element.trigger('show');
            if ($.isFunction(callback)) { callback(); };
          }, this));
          
          return this;
        },

        hide: function(callback) {
          if (this.hidden) { return this; };
          if (this.transition) { this.transition.stop(); };
          if (this.shim) { this.shim.css('display', 'none'); };
          this.target.unbind('resize');
          this.hidden = true;

          this.transition = this.element.fadeTo(this.options.closeDuration, 0, $.proxy(function(){
            this.element.trigger('hide');
            if ($.isFunction(callback)) { callback(); };
            this.element.css({ 'height': 0, 'width': 0, 'display': 'none' });
          }, this));

          return this;
        }
      },

      create: function(options)
      {
        this.options = $.extend(true, this.defaults, options);

        var name     = this.options.name;
        var lightbox = $('<div class="'+name+' '+name+'-mode-image"><div class="'+name+'-border-top-left"></div><div class="'+name+'-border-top-middle"></div><div class="'+name+'-border-top-right"></div><a class="'+name+'-button-close" href="#close"><span>Close</span></a><div class="'+name+'-navigator"><a class="'+name+'-button-left" href="#"><span>Previous</span></a><a class="'+name+'-button-right" href="#"><span>Next</span></a></div><div class="'+name+'-buttons"><div class="'+name+'-buttons-init"></div><a class="'+name+'-button-left" href="#"><span>Previous</span></a><a class="'+name+'-button-max" href="#"><span>Maximize</span></a><div class="'+name+'-buttons-custom"></div><a class="'+name+'-button-right" href="#"><span>Next</span></a><div class="'+name+'-buttons-end"></div></div><div class="'+name+'-background"></div><div class="'+name+'-html"></div><div class="'+name+'-border-bottom-left"></div><div class="'+name+'-border-bottom-middle"></div><div class="'+name+'-border-bottom-right"></div></div>');
        var e        = this.esqueleto;

        this.overlay.create({
          name          : name,
          style         : this.options.overlay,
          modal         : this.options.modal,
          zIndex        : this.options.style.zIndex-1,
          callback      : this.proxy(this.close),
          showDuration  : (is_smartphone ? 2 : this.options.animation.show.duration),
          closeDuration : (is_smartphone ? 2 : this.options.animation.close.duration)
        });
        
        e.lightbox       = lightbox;
        e.navigator      = $('.'+name+'-navigator', lightbox);
        e.buttons.div    = $('.'+name+'-buttons', lightbox);
        e.buttons.close  = $('.'+name+'-button-close', lightbox);
        e.buttons.prev   = $('.'+name+'-button-left', lightbox);
        e.buttons.max    = $('.'+name+'-button-max', lightbox);
        e.buttons.next   = $('.'+name+'-button-right', lightbox);
        e.buttons.custom = $('.'+name+'-buttons-custom', lightbox);
        e.background     = $('.'+name+'-background', lightbox);
        e.html           = $('.'+name+'-html', lightbox);

        e.move = $('<div class="'+name+'-move"></div>').css({
          'position' : 'absolute',
          'z-index'  : this.options.style.zIndex,
          'top'      : -999
        }).append(lightbox);
        
        $('body').append(e.move);

        // this.win = (window!=window.top) ? window.top : window;
        this.win = $(window);
        
        this.addevents();
        return lightbox;
      },

      addevents: function()
      {
        var $win  = this.win;

        $win[0].onorientationchange = function()
        { 
          $win.trigger('resize');
        };
        
        $win.bind('resize', this.proxy(function()
        {
          if (this.visible)
          {
            this.overlay.resize();
            if (!this.maximized)
            {
              this.movebox();
            }
          }
        }));

        $win.bind('scroll', this.proxy(function()
          {
            if (this.visible && !this.maximized)
            {
              this.movebox();
            }
          }
        ));

        $(document).bind('keydown', this.proxy(function(e)
          {
            if (this.visible)
            {
              if (e.keyCode === 27 && this.options.modal === false) // esc
              {
                this.close();
              }

              if (this.gallery.total > 1)
              {
                if (e.keyCode === 37) // left
                {
                  this.esqueleto.buttons.prev.triggerHandler('click', e);
                }

                if (e.keyCode === 39) // right
                {
                  this.esqueleto.buttons.next.triggerHandler('click', e);
                }
              }
            }
          }
        ));
        
        this.esqueleto.buttons.close.bind('click touchend', {"fn": "close"}, this.proxy(this.fn));

        this.esqueleto.buttons.max.bind('click touchend', {"fn": "maximinimize"}, this.proxy(this.fn));
        
        // heredamos los eventos, desde el overlay:
        this.overlay.element.bind('show', this.proxy(function()
          {
            $(this).triggerHandler('show');
          }
        ));
        
        this.overlay.element.bind('hide', this.proxy(function()
          {
            $(this).triggerHandler('close');
          }
        ));
      },

      fn: function(e)
      {
        this[e.data.fn].apply(this);
        e.preventDefault();
      },

      proxy: function(fn)
      {
        return $.proxy(fn, this);
      },
      
      ex: function(ob, href, options)
      {
        var tmp = {
          type   : "",
          width  : "",
          height : "",
          href   : ""
        };

        $.each(ob, this.proxy(function(is, reg)
          {
            $.each(reg, this.proxy(function(i, e)
              {
                if ((is == "flash" && href.split('?')[0].match(e.reg)) || (is == "iframe" && href.match(e.reg)))
                {
                  tmp.href = href;
                  if (e.split)
                  {
                    var id   = is == "flash" ? href.split(e.split)[e.index].split('?')[0].split('&')[0] : href.split(e.split)[e.index];
                    tmp.href = e.url.replace("%id%", id).replace("%width%", options.width).replace("%height%", options.height);;
                  }

                  tmp.type   = e.iframe ? "iframe" : is;
                  tmp.width  = options.width || this.options[tmp.type].width;
                  tmp.height = options.height || this.options[tmp.type].height;
                  return false;
                }
              }
            ));

            if (!!tmp.type) return false;

          }
        ));

        return tmp;
      },
      
      create_gallery: function(collection, options)
      {
        var $prev = this.esqueleto.buttons.prev;
        var $next = this.esqueleto.buttons.next;

        this.gallery.total = collection.length;

        if (collection.length > 1)
        {
          $prev.unbind('.lightbox');
          $next.unbind('.lightbox');

          $prev.bind('click.lightbox touchend.lightbox', this.proxy(function(e)
            {
              e.preventDefault();
              collection.unshift(collection.pop());
              this.show(collection);
            }
          ));

          $next.bind('click.lightbox touchend.lightbox', this.proxy(function(e)
            {
              e.preventDefault();
              collection.push(collection.shift());
              this.show(collection);
            }
          ));

          if (this.esqueleto.navigator.css("display") === "none")
          {
            this.esqueleto.buttons.div.show();
          }

          $prev.show();
          $next.show();
        }
        else
        {
          $prev.hide();
          $next.hide();
        }
      },
      
      custombuttons: function(buttons, anchor)
      {
        var esqueleto = this.esqueleto;
        esqueleto.buttons.custom.empty();

        $.each(buttons, this.proxy(function(i, button)
          {
            var $a = $('<a href="#" class="'+button['class']+'">'+button['html']+'</a>');
            $a.bind('click', this.proxy(function(e)
              {
                if ($.isFunction(button.callback))
                {
                  button.callback(this.esqueleto.image.src, this, anchor);
                }
                e.preventDefault();
              }
            ));

            esqueleto.buttons.custom.append($a);
          }
        ));

        esqueleto.buttons.div.show();
      },
      
      show: function(collection, options, callback)
      {
        // Si collection esta vacio no tenemos nada mas que hacer:
        if (this.utils.isEmpty(collection))
        {
          return false;
        }

        // Como siempre le pasaremos un array en collection,
        // solo queremos trabajar con el primer elemento:
        var me         = collection[0];
        var type       = '';
        var beforeopen = false;

        var href       = me.href;
        var esqueleto  = this.esqueleto;

        var size = {
          x: this.win.width(),
          y: this.win.height()
        };

        var width, height;

        // Comprobacion especial para: lightbox($("<div/>")
        if (collection.length === 1 && me.type === "element")
        {
          type = "element";
        }

        this.loading();
        beforeopen = this.visible;
        this.open();

        if (beforeopen === false)
        {
          this.movebox();
        }

        // Creamos, si es necesario, la galeria y mostramos los botones atras y adelante:
        this.create_gallery(collection, options);

        options = $.extend(true, {
          'width'      : 0,
          'height'     : 0,
          'modal'      : 0,
          'force'      : '',
          'autoresize' : true,
          'move'       : -1,
          'iframe'     : false,
          'flashvars'  : '',
          'cufon'      : true,
          'onOpen'     : function() {},
          'onClose'    : function() {}
        }, options || {}, me);
        
        // Eventos
        this.options.onOpen   = options.onOpen;
        this.options.onClose  = options.onClose;

        this.options.cufon    = options.cufon;
        
        // A veces las opciones vienen en la URL:
        var urloptions = this.unserialize(href);
        options        = $.extend({}, options, urloptions);

        // Calcular porcentajes si es que existen:
        if (options.width && (""+options.width).indexOf("p") > 0)
        {
          options.width = (size.x-20) * options.width.substring(0, options.width.indexOf("p")) / 100;
        }

        if (options.height && (""+options.height).indexOf("p") > 0)
        {
          options.height = (size.y-20) * options.height.substring(0, options.height.indexOf("p")) / 100;
        }
        
        this.overlay.options.modal = options.modal;

        esqueleto.buttons.max.removeClass(this.options.name+'-button-min').addClass(this.options.name+'-button-max');

        this.maximized = !(options.move > 0 || (options.move == -1 && options.autoresize));

        if ($.isArray(options.buttons))
        {
          this.custombuttons(options.buttons, me.element);
        }
        
        if (this.esqueleto.buttons.custom.is(":empty") === false)
        {
          this.esqueleto.buttons.div.show();
        }

        esqueleto.buttons.max.hide();
        
        if (this.utils.isEmpty(options.force) === false)
        {
          type = options.force;
        }
        else if (options.iframe)
        {
          type = 'iframe';
        }
        else if (href.match(this.imgsreg))
        {
          type = 'image';
        }
        else
        {
          // Detectar si es un flash o un mapa o un video:
          var zap = this.ex({"flash": this.videoregs, "iframe": this.mapsreg}, href, options);
          if (!!zap.type === true)
          {
            href           = zap.href;
            type           = zap.type;
            options.width  = zap.width;
            options.height = zap.height;
          }

          // Si todavia no sabemos que es, lo mas probable es que sea una url ajax o un #inline:
          if (!!type === false)
          {
            if (href.match(/#/))
            {
              var obj = href.substr(href.indexOf("#"));
              if ($(obj).length > 0)
              {
                type = 'inline';
                href = obj;
              }
              else
              {
                type = 'ajax';
              }
            }
            else
            {
              type = 'ajax';
            }
          }
        }

        if (type === 'image')
        {
          esqueleto.image = new Image();

          $(esqueleto.image).load(this.proxy(function()
            {
              var image = this.esqueleto.image;
              $(image).unbind('load');
              
              if (this.visible === false)
              {
                return false
              }
              
              // Si el tamaño viene definido en los parametros:
              if (options.width)
              {
                width   = parseInt(options.width, 10);
                height  = parseInt(options.height, 10);
              }
              // Si no sabemos el tamaño, entonces lo calcularemos:
              else
              {
                if (options.autoresize)
                {
                  var objsize = this.calculate(image.width, image.height);
                  width   = objsize.width;
                  height  = objsize.height;

                  // Si el tamaño calculado no coincide con el tamaño real, mostraremos la botonera para "agrandar" imagen:
                  if (image.width != width || image.height != height)
                  {
                    this.esqueleto.buttons.div.show();
                    this.esqueleto.buttons.max.show();
                  }
                }
                else
                {
                  width   = image.width;
                  height  = image.height;
                }
              }

              this.esqueleto.title = (this.utils.isEmpty(options.title)) ? false : $('<div class="'+this.options.name+'-title"></div>').html(options.title);

              this.loadimage();

              this.resize(width, height);
            }
          ));
          
          this.esqueleto.image.onerror = this.proxy(function()
          {
            this.error("The requested image cannot be loaded. Please try again later.");
          });
          
          this.esqueleto.image.src = href;
        }
        else if (type=='flash' || type=='inline' || type=='ajax' || type=='element')
        {
          if (type == 'inline')
          {
            var orig = $(href);
            var html = orig.clone(true).show();

            width    = options.width  > 0 ? options.width  : orig.outerWidth(true);
            height   = options.height > 0 ? options.height : orig.outerHeight(true);

            this.appendhtml(html, width, height);
          }
          else if (type == 'ajax')
          {
            if (options.width)
            {
              width   = options.width;
              height  = options.height;
            }
            else
            {
              this.error("You have to specify the size. Add ?lightbox[width]=600&lightbox[height]=400 at the end of the url.");
              return false;
            }

            if (this.animations.ajax)
            {
              this.animations.ajax.abort();
            }

            this.animations.ajax = $.ajax($.extend({}, this.options.ajax, {
              url    : href,
              error  : this.proxy(function(jqXHR, textStatus, errorThrown)
              {
                this.error("AJAX Error " + jqXHR.status + " " + errorThrown);
              }),
              success: this.proxy(function(html)
              {
                this.appendhtml($(html), width, height);
              })
            }));
          }
          else if (type == 'flash')
          {
            var flash = this.swf2html(href, options.width, options.height, options.flashvars);
            this.appendhtml($(flash), options.width, options.height, 'flash');
          }
          else if (type === 'element')
          {
            width    = options.width > 0 ? options.width : me.element.outerWidth(true);
            height   = options.height > 0 ? options.height : me.element.outerHeight(true);
            this.appendhtml(me.element, width, height);
          }
        }
        else if (type=='iframe')
        {
          if (options.width)
          {
            width   = options.width;
            height  = options.height;
          }
          else
          {
            this.error("You have to specify the size. Add ?lightbox[width]=600&lightbox[height]=400&lighbox[iframe]=true at the end of the url.");
            return false;
          }

          var iframeHTML = '<iframe id="IF_'+(new Date().getTime())+'" frameborder="0" src="'+href+'" style="margin:0; padding:0;"></iframe>';
          this.appendhtml($(iframeHTML).css({width: options.width, height: options.height}), options.width, options.height);
        }

        this.callback = $.isFunction(callback) ? callback : function(e) {};
      },

      loadimage: function()
      {
        var esqueleto    = this.esqueleto;
        var background   = esqueleto.background;
        var classloading = this.options.name + '-loading';

        background.bind('complete', this.proxy(function()
          {
            background.unbind('complete');

            if (this.visible === false)
            {
              return false
            }

            this.changemode('image');

            background.empty();
            esqueleto.html.empty();

            if (esqueleto.title)
            {
              background.append(esqueleto.title);
            }

            background.append(esqueleto.image);
            
            if (is_ie6 || is_smartphone)
            {
              background.removeClass(classloading);
            }
            else
            {
              // Firefox 10+ bug:
              $(esqueleto.image).css("background-color", "rgba(255, 255, 255, 0)");

              $(esqueleto.image).stop().css("opacity", 0).animate({"opacity" : 1}, 400, function()
                {
                  background.removeClass(classloading);
                }
              );
            }

            this.options.onOpen.apply(this);
          }
        ));
      },
            
      swf2html: function(href, width, height, flashvars)
      {
        if (typeof flashvars == 'undefined' || flashvars == '') flashvars = 'autostart=1&autoplay=1&fullscreenbutton=1';
        var str = '<object width="'+width+'" height="'+height+'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param name="movie" value="'+href+'" style="margin:0; padding:0;"></param>';
        str += '<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><param name="wmode" value="transparent"></param>';
        str += '<param name="autostart" value="true"></param><param name="autoplay" value="true"></param><param name="flashvars" value="'+flashvars+'"></param>';
        str += '<param name="width" value="'+width+'"></param><param name="height" value="'+height+'"></param>';
        str += '<embed src="'+href+'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" autostart="true" autoplay="true" flashvars="'+flashvars+'" wmode="transparent" width="'+width+'" height="'+height+'" style="margin:0; padding:0;"></embed></object>';
        return str;
      },
      
      appendhtml: function(obj, width, height, mode)
      {
        var esqueleto  = this.esqueleto;
        var background = esqueleto.background;
        this.changemode("html");
        
        this.resize(width + 30, height + 20);

        background.bind('complete', this.proxy(function() {
          background.removeClass(this.options.name+'-loading');
          esqueleto.html.append(obj);

          if (mode == "flash" && usearch("chrome") > -1)
          {
            this.esqueleto.html.html(obj); // double line to fix chrome bug
          }

          background.unbind('complete');

          if (this.options.cufon && typeof Cufon !== 'undefined')
          {
            Cufon.refresh();
          }

          this.options.onOpen.apply(this);
        }));
        
      },
      
      movebox: function(w, h)
      {
        var size   = {
          x: $(this.win).width(),
          y: $(this.win).height()
        };

        var scroll = {
          x: $(this.win).scrollLeft(),
          y: $(this.win).scrollTop()
        };

        var esqueleto = this.esqueleto;
        var height    = h!=null ? h : esqueleto.lightbox.outerHeight();
        var width     = w!=null ? w : esqueleto.lightbox.outerWidth();

        var y = 0;
        var x = 0;

         //vertically center
        x = scroll.x + ((size.x - width) / 2);

        if (this.visible)
        {
          y = scroll.y + (size.y - height) / 2;
        }
        else if (this.options.emergefrom == "bottom")
        {
          y = (scroll.y + size.y + 14);
        }
        // top
        else if (this.options.emergefrom == "top")
        {
          y = (scroll.y - height) - 14;
        }
        
        if (this.visible)
        {
          if (!this.animations.move)
          {
            this.morph(esqueleto.move, {
              'left' : x
            }, 'move');
          }

          this.morph(esqueleto.move, {
            'top'  : y
          }, 'move');

        }
        else
        {
          esqueleto.move.css({
            'left' : x,
            'top'  : y
          });
        }
      },

      morph: function(el, prop, mode, callback, queue)
      {
        var optall = $.speed({
          queue     : queue || false,
          duration  : (is_smartphone ? 2 : this.options.animation[mode].duration),
          easing    : this.options.animation[mode].easing,
          complete  : ($.isFunction(callback) ? this.proxy(callback, this) : null)
        });
        
        return el[ optall.queue === false ? "each" : "queue" ](function()
        {
          if (parseFloat($.fn.jquery) > 1.5)
          {
            if (optall.queue === false)
            {
              $._mark( this );
            }
          }

          var opt = $.extend({}, optall), self = this;

          opt.curAnim = $.extend({}, prop);

          opt.animatedProperties = {};

          for (var p in prop)
          {
            name = p;
            opt.animatedProperties[ name ] = opt.specialEasing && opt.specialEasing[ name ] || opt.easing || 'swing';
          }

          $.each( prop, function(name, val)
          {
            var e = new $.fx(self, opt, name);

            e.custom(e.cur(true) || 0, val, "px");
          });

          return true;
        });
      },
      
      resize: function(x, y)
      {
        var esqueleto = this.esqueleto;
        if (this.visible)
        {
          var size   = {
            x: $(this.win).width(),
            y: $(this.win).height()
          };

          var scroll = {
            x: $(this.win).scrollLeft(),
            y: $(this.win).scrollTop()
          };

          var left   = (scroll.x + (size.x - (x + 14)) / 2);
          var top    = (scroll.y + (size.y - (y + 14)) / 2);
          
          if ($.browser.msie || ($.browser.mozilla && (parseFloat($.browser.version) < 1.9)))
          {
            y += 4;
          }
          
          this.animations.move = true;

          this.morph(esqueleto.move.stop(), {
            'left': (this.maximized && left < 0) ? 0 : left,
            'top' : (this.maximized && (y + 14) > size.y) ? scroll.y : top
          }, 'move', $.proxy(function() { this.move = false; }, this.animations));

          this.morph(esqueleto.html, { 'height': y - 20 }, 'move');
          this.morph(esqueleto.lightbox.stop(), { 'width': (x + 14), 'height': y - 20 }, 'move', {}, true);
          this.morph(esqueleto.navigator, { 'width': x }, 'move');
          this.morph(esqueleto.navigator, { 'top': (y - 90) / 2 }, 'move');
          this.morph(esqueleto.background.stop(), { 'width': x, 'height': y }, 'move', function() { $(esqueleto.background).trigger('complete'); });
        }
        else
        {
          esqueleto.html.css({ 'height': y - 20 });
          esqueleto.lightbox.css({ 'width': x + 14, 'height': y - 20 });
          esqueleto.background.css({ 'width': x, 'height': y });
          esqueleto.navigator.css({ 'width': x, 'height': 90 });
        }
      },
      
      close: function(param)
      {
        var esqueleto = this.esqueleto;
        this.visible = false;
        this.gallery = {};
        
        this.options.onClose();
        
        if ($.browser.msie || is_smartphone)
        {
          esqueleto.background.empty();
          esqueleto.html.hide().empty().show();
          esqueleto.buttons.custom.empty();
          esqueleto.move.css("display", "none");
          this.movebox();
        }
        else
        {
          esqueleto.move.animate({"opacity": 0, "top": "-=40"}, {
            queue     : false,
            complete  : (this.proxy(function() {
              esqueleto.background.empty();
              esqueleto.html.empty();
              esqueleto.buttons.custom.empty();
              this.movebox();
              esqueleto.move.css({
                "display": "none",
                "opacity": 1,
                "overflow": "visible"
              });
            }))
          });
        }
        
        this.overlay.hide(this.proxy(function() {
          if ($.isFunction(this.callback))
          {
            this.callback.apply(this, $.makeArray(param));
          }
        }));

        esqueleto.background.stop(true, false).unbind("complete");
      },
      
      open: function()
      {
        this.visible = true;

        if ($.browser.msie)
        {
          this.esqueleto.move.get(0).style.removeAttribute("filter");
        }

        this.esqueleto.move.stop().css({
          opacity  : 1,
          display  : "block",
          overflow : "visible"
        }).show();

        this.overlay.show();
      },

      shake: function()
      {
        var z = this.options.animation.shake;
        var x = z.distance;
        var d = z.duration;
        var t = z.transition;
        var o = z.loops;
        var l = this.esqueleto.move.position().left;
        var e = this.esqueleto.move;

        for (var i=0; i<o; i++)
        {
         e.animate({left: l+x}, d, t);
         e.animate({left: l-x}, d, t);
        };

        e.animate({left: l+x}, d, t);
        e.animate({left: l},   d, t);
      },
      
      changemode: function(mode)
      {
        if (mode != this.mode)
        {
          var classmode = this.options.name + "-mode-";
          // Elimina el mode viejo, e inserta el mode nuevo:
          this.esqueleto.lightbox.removeClass(classmode + this.mode).addClass(classmode + mode);
          this.mode = mode;
        }

        this.esqueleto.move.css("overflow", "visible");
      },
      
      error: function(msg)
      {
        alert(msg);
        this.close();
      },
      
      unserialize: function(data)
      {
        var regex       = /lightbox\[([^\]]*)?\]$/i;
        var serialised  = {};

        if (data.match(/#/))
        {
          data = data.slice(0, data.indexOf("#"));
        }

        data = data.slice(data.indexOf('?') + 1).split("&");
        
        $.each(data, function()
          {
            var properties = this.split("=");
            var key        = properties[0];
            var value      = properties[1];
            
            if (key.match(regex))
            {
              if (isFinite(value))
              {
                value = parseInt(value, 10)
              }
              else if (value.toLowerCase() == "true")
              {
                value = true;
              }
              else if (value.toLowerCase() == "false")
              {
                value = false;
              }
              serialised[key.match(regex)[1]] = value;
            }
          }
        );

        return serialised;
      },
      
      calculate: function(x, y)
      {
        // Resizing large images
        var maxx = this.options.maxsize.width > 0 ? this.options.maxsize.width : this.win.width() - 50;
        var maxy = this.options.maxsize.height > 0 ? this.options.maxsize.height : this.win.height() - 50;

        if (x > maxx)
        {
          y = y * (maxx / x);
          x = maxx;
          if (y > maxy)
          {
            x = x * (maxy / y);
            y = maxy;
          }
        }
        else if (y > maxy)
        {
          x = x * (maxy / y);
          y = maxy;
          if (x > maxx)
          {
            y = y * (maxx / x);
            x = maxx;
          }
        }
        // End Resizing
        return {
          width : parseInt(x, 10),
          height: parseInt(y, 10)
        };
      },

      loading: function()
      {
        var size        = this.options.style;
        var $background = this.esqueleto.background;

        this.changemode('image');

        $background.children().stop(true);
        $background.empty();
        this.esqueleto.html.empty();

        $background.addClass(this.options.name+'-loading');
        this.esqueleto.buttons.div.hide();

        if (this.visible == false)
        {
          this.movebox(size["width"], size["height"]);
          this.resize(size["width"], size["height"]);
        }
      },

      maximinimize: function()
      {
        var $buttons = this.esqueleto.buttons;
        var $image   = this.esqueleto.image;
        var name     = this.options.name;

        if (this.maximized)
        {
          this.maximized = false;
          $buttons.max.removeClass(name + '-button-min').addClass(name + '-button-max');

          this.loading();
          this.loadimage();
          $buttons.div.show();

          var size = this.calculate($image.width, $image.height);
          this.resize(size.width, size.height);
        }
        else
        {
          this.maximized = true;
          $buttons.max.removeClass(name+'-button-max').addClass(name+'-button-min');

          this.loading();
          this.loadimage();
          $buttons.div.show();

          this.resize($image.width, $image.height);
        }
      },

      getOptions: function(el)
      {
        var el = $(el);

        // 1. El href indispensable.
        // 2. Obtenemos los rel para las galerias.
        // 3. HTML5 por defecto para el titulo.
        // 4. Element para enviar en el contexto de los custombuttons.
        // 5. Agregamos cualquier data-options en formato json.

        return $.extend({}, {
            href    : el.attr("href"),
            rel     : ($.trim(el.attr("data-rel") || el.attr("rel"))),
            relent  : el.attr("data-rel") ? "data-rel" : "rel",
            title   : $.trim(el.attr("data-title") || el.attr("title")),
            element : el[0]
          }, $.parseJSON(el.attr("data-options"))
        );
      },

      link: function(event, args)
      {
        var $this      = $(args.element);
        var me         = this.getOptions($this);
        var rel        = me.rel;
        var relEntity  = me.relent;
        var options    = args.options;
        var collection = [];

        // Quitamos el foco al link clickeado:
        $this.blur();

        // Podria ser una galeria llamada desde link:
        if (args.gallery)
        {
          collection = args.gallery;
        }
        // Si no tiene rel, entonces es una imagen solitaria:
        else if (this.utils.isEmpty(rel) || rel === 'nofollow')
        {
          // Creamos un array de un elemento:
          collection = [me];
        }
        // Si por el contrario existe un rel, es probable que pertenezca a una galeria:
        else
        {
          var before = [];
          var after  = [];
          var found  = false;
          
          // Escanea todo el DOM en busca de otros elementos con el mismo rel:
          $("a[" + relEntity + "], area[" + relEntity + "]", this.ownerDocument).filter("[" + relEntity + "=\"" + rel + "\"]").each($.proxy(function(i, el)
            {
              if ($this[0] === el)
              {
                // Agrega el elemento al principio del array "before":
                before.unshift(this.getOptions(el));
                found = true;
              }
              else if (found == false)
              {
                after.push(this.getOptions(el));
              }
              else
              {
                before.push(this.getOptions(el));
              }
            },
          this));

          // En este punto, sel sera el array de todos los elementos con el mismo rel, ordenados:
          collection = before.concat(after);
        }

        $.lightbox(collection, options, args.callback, $this);

        return false;
      },

      utils: {
        isEmpty: function(obj)
        {
          if (obj == null) return true;
          if (Object.prototype.toString.call(obj) === '[object String]' || $.type(obj) === "array") return obj.length === 0;
        }
      }
      
    }, // ------------------- end class object
   
    lightbox: function(url, options, callback)
    {
      var temp = [];

      // Si url esta vacio devolveremos el objeto de la clase: $.lightbox() = LightBoxObject;
      if ($.LightBoxObject.utils.isEmpty(url))
      {
        return $.LightBoxObject;
      }

      // Si es un string, osea: $.lightbox("image1.jpg");
      if ($.type(url) === "string")
      {
        temp = [$.extend({}, {
          href: url
        }, options)];
      }
      else if ($.type(url) === "array")
      {
        var firstEl = url[0];

        // Es un array simple: $.lightbox(["image1.jpg", "image2.jpg"]);
        if ($.type(firstEl) === "string")
        {
          for (var i = 0; i < url.length; i++)
          {
            temp[i] = $.extend({}, {
              href: url[i]
            }, options);
          };
        }
        // Es un array con las opciones incrustadas: $.lightbox([{href: "image1.jpg", title: "holis"}]);
        else if ($.type(firstEl) === "object")
        {
          for (var i = 0; i < url.length; i++)
          {
            // La razon por la cual ponemos options primero y luego url[i],
            // es que queremos sobrescribir las opciones "genericas" por las de cada elemento:
            temp[i] = $.extend({}, options, url[i]);
          };
        }
      }
      // Es un objeto DOM de jquery: lightbox($("<div/>"));
      else if ($.type(url) === "object" && url[0].nodeType)
      {
        temp = [$.extend({}, {
          type    : "element",
          href    : "#",
          element : url
        }, options)];
      }

      return $.LightBoxObject.show(temp, options, callback);
    }
    
  });
  
  $.fn.lightbox = function(options, callback)
  {
    var args     = {
      "selector" : this.selector,
      "options"  : options,
      "callback" : callback
    };

    return $(this).live('click', function(e)
      {
        return $.proxy($.LightBoxObject.link, $.LightBoxObject)(e, $.extend({}, args, {"element": this}));
      }
    );
  };
  
  $(function()
    {
      // Solo funciona con jQuery 1.3+. Si tenemos una version mas vieja, tiramos error:
      if (parseFloat($.fn.jquery) > 1.2)
      {
        $.LightBoxObject.create();
      }
      else
      {
        throw "The jQuery version that was loaded is too old. Lightbox Evolution requires jQuery 1.3+";
      }
    }
  );
  
})(jQuery, window, document);