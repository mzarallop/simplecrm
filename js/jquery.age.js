// Generated by CoffeeScript 1.6.3
/*
jQuery Age
Copyright 2013 Kevin Sylvestre
1.2.4
*/


(function() {
  "use strict";
  var $, Age,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  $ = jQuery;

  Age = (function() {
    Age.settings = {
      singular: 1,
      interval: 1000,
      suffixes: {
        past: "",
        future: ""
      },
      prefixes: {
        past: "Hace",
        future: "Será"
      },
      units: ["years", "months", "weeks", "days", "hours", "minutes", "seconds"],
      formats: {
        now: "now",
        singular: {
          seconds: "un segundo",
          minutes: "un minuto",
          hours: "una hora",
          days: "un día",
          weeks: "una semana",
          months: "un mes",
          years: "un año"
        },
        plural: {
          seconds: "{{amount}} segundos",
          minutes: "{{amount}} minutos",
          hours: "{{amount}} horas",
          days: "{{amount}} días",
          weeks: "{{amount}} semanas",
          months: "{{amount}} meses",
          years: "{{amount}} años"
        },
        tiny: {
          seconds: "{{amount}}s",
          minutes: "{{amount}}m",
          hours: "{{amount}}h",
          days: "{{amount}}d",
          weeks: "{{amount}}w",
          months: "{{amount}}m",
          years: "{{amount}}y"
        }
      }
    };

    function Age($el, settings) {
      if (settings == null) {
        settings = {};
      }
      this.text = __bind(this.text, this);
      this.interval = __bind(this.interval, this);
      this.format = __bind(this.format, this);
      this.unit = __bind(this.unit, this);
      this.amount = __bind(this.amount, this);
      this.formatting = __bind(this.formatting, this);
      this.adjust = __bind(this.adjust, this);
      this.prefix = __bind(this.prefix, this);
      this.suffix = __bind(this.suffix, this);
      this.date = __bind(this.date, this);
      this.reformat = __bind(this.reformat, this);
      this.$el = $el;
      this.settings = $.extend({}, Age.settings, settings);
      this.reformat();
    }

    Age.prototype.reformat = function() {
      var interval;
      interval = this.interval();
      this.$el.html(this.text(interval));
      return setTimeout(this.reformat, this.settings.interval);
    };

    Age.prototype.date = function() {
      return new Date(this.$el.attr('datetime') || this.$el.attr('date') || this.$el.attr('time'));
    };

    Age.prototype.suffix = function(interval) {
      if (interval < 0) {
        return this.settings.suffixes.past;
      }
      if (interval > 0) {
        return this.settings.suffixes.future;
      }
    };

    Age.prototype.prefix = function(interval) {
      if (interval < 0) {
        return this.settings.prefixes.past;
      }
      if (interval > 0) {
        return this.settings.prefixes.future;
      }
    };

    Age.prototype.adjust = function(interval, scale) {
      return Math.floor(Math.abs(interval / scale));
    };

    Age.prototype.formatting = function(interval) {
      return {
        seconds: this.adjust(interval, 1000),
        minutes: this.adjust(interval, 1000 * 60),
        hours: this.adjust(interval, 1000 * 60 * 60),
        days: this.adjust(interval, 1000 * 60 * 60 * 24),
        weeks: this.adjust(interval, 1000 * 60 * 60 * 24 * 7),
        months: this.adjust(interval, 1000 * 60 * 60 * 24 * 30),
        years: this.adjust(interval, 1000 * 60 * 60 * 24 * 365)
      };
    };

    Age.prototype.amount = function(formatting) {
      return formatting[this.unit(formatting)] || 0;
    };

    Age.prototype.unit = function(formatting) {
      var unit, _i, _len, _ref;
      _ref = this.settings.units;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        unit = _ref[_i];
        if (formatting[unit] > 0) {
          return unit;
        }
      }
      return void 0;
    };

    Age.prototype.format = function(amount, unit) {
      var _ref, _ref1;
      if (this.settings.style != null) {
        return (_ref = this.settings.formats[this.settings.style]) != null ? _ref[unit] : void 0;
      }
      return (_ref1 = this.settings.formats[amount === this.settings.singular ? 'singular' : 'plural']) != null ? _ref1[unit] : void 0;
    };

    Age.prototype.interval = function() {
      return this.date() - new Date;
    };

    Age.prototype.text = function(interval) {
      var amount, format, formatting, prefix, suffix, unit;
      if (interval == null) {
        interval = this.interval();
      }
      if (interval > 0 && (this.settings.pending != null)) {
        return this.settings.pending;
      }
      if (interval < 0 && (this.settings.expired != null)) {
        return this.settings.expired;
      }
      suffix = this.suffix(interval);
      prefix = this.prefix(interval);
      formatting = this.formatting(interval);
      amount = this.amount(formatting);
      unit = this.unit(formatting);
      format = this.format(amount, unit);
      if (!format) {
        return this.settings.formats.now;
      }
      return ("" + prefix + " " + (format.replace('{{unit}}', unit).replace('{{amount}}', amount)) + " " + suffix).trim();
    };

    return Age;

  })();

  $.fn.extend({
    age: function(options) {
      if (options == null) {
        options = {};
      }
      return this.each(function() {
        return new Age($(this), options);
      });
    }
  });

}).call(this);
