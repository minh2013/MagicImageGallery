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
                src: ['<%= meta.path %>/css/!(gallery).css'],
                dest: '<%= meta.path %>/css/gallery.css'  
            }
        },
        uglify: {
            dist: {
                src: ['<%= concat.js.dest %>'],
                dest: '<%= concat.js.dest %>'
            }    
             
        }
    });
    // Default task.
    grunt.registerTask('default', ['concat', 'uglify']);
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
};