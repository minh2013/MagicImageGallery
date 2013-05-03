/*global module:false*/
module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        meta: {
            path: 'public'
        },
        concat: {
            js: {
                src: ['<%= meta.path %>/js/!(gallery).js'],
                dest: '<%= meta.path %>/js/gallery.js'
            },
            css: {
                src: ['<%= meta.path %>/css/*.css'],
                dest: '<%= meta.path %>/css/gallery.css'  
            }
        },
        uglify: {
            dist: {
                src: ['<%= concat.js.dest %>'],
                dest: '<%= concat.js.dest %>'
            }    
             
        },
        less: {
            prduction: {
                files: {
                    "<%= meta.path %>/css/gallery.css": "<%= meta.path %>/less/**/*.less"
                }
            }
        }
    });
    // Default task.
    grunt.registerTask('default', ['less', 'concat', 'uglify']);
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
};