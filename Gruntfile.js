/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    meta: {
      version: '0.1.0',
      banner: '/*! MagicImageGallery - v<%= meta.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> ' +
        'Minh */',
      package_path: 'public'
    },
    lint: {
      files: ['grunt.js', 'lib/**/*.js', 'test/**/*.js']
    },
    concat: {
      js: {
        src: ['<%= meta.package_path %>/js/!(gallery).js'],
        dest: '<%= meta.package_path %>/js/gallery.js'
      },
      css: {
        src: ['<%= meta.package_path %>/css/gallery.css'],
        dest: '<%= meta.package_path %>/css/gallery.css'
      }
    },
    uglify: {
      dist: {
        src: ['<%= concat.js.dest %>'],
        dest: '<%= concat.js.dest %>'
      }
    },
    watch: {
      js: {
        files: ['<%= meta.package_path %>/js/!(gallery).js'],
        tasks: ['concat:js'/*, 'uglify'*/, 'reload']
      },
      less: {
        files: ['<%= meta.package_path %>/less/**/*.less'],
        tasks: ['less', 'concat:css', 'reload'],
        options: {
          debounceDelay: 250
        }
      },
      html: {
        files: ['<%= meta.package_path %>/**/*.php'],
        tasks: 'reload'
      }
    },
    less: {
      index: {
        options: {
          //'yuicompress': true
        },
        files: {
          "<%= meta.package_path %>/css/gallery.css": "<%= meta.package_path %>/less/gallery.less"
        }
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        boss: true,
        eqnull: true,
        browser: true
      },
      globals: {}
    },
    reload: {
      port: 35729, // LR default
      liveReload: {}
    }
  });

  // Default task.
  grunt.registerTask('hello', function() {
    console.log(grunt.config.get('meta.package_path'));
  });
  grunt.registerTask('start', ['reload', 'watch']);
  grunt.registerTask('default', ['concat', 'uglify', 'less']);
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-nodeunit');
  grunt.loadNpmTasks('grunt-contrib-watch');
 // grunt.loadNpmTasks('grunt-reload');

};