module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // TASKS

        // JS Concatenation

        concat: {   
            dist: {
                src: [
                    'assets/js/plugins.js',
                    'assets/js/scripts.js'
                ],
                dest: 'assets/js/production.js',
            }
        },

        // JS Minify

        uglify: {
            build: {
                src: 'assets/js/production.js',
                dest: 'assets/js/production.min.js'
            }
        },

        // Image optimisation

        imagemin: {
            dynamic: {
                files: [{
                    expand: true,
                    cwd: 'assets/img/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'assets/img/'
                }]
            }
        },

        // Compass Concatenation

        compass: {
            dist: {
                options: {
                    sassDir: 'assets/scss',
                    cssDir: 'assets/css',
                    environment: 'production'
                }
            },
            dev: {
                options: {
                sassDir: 'assets/scss',
                cssDir: 'assets/css'
                }
            }
        },

        // Watch events

        watch: {
            scripts: {
                files: ['assets/js/*.js'],
                tasks: ['concat', 'uglify'],
                options: {
                    spawn: false,
                },
            },
            css: {
                files: ['assets/scss/**/*.scss'],
                tasks: ['compass'],
                options: {
                    spawn: false,
                }
            },
           images: {
                files: ['assets/img/*.{png,jpg,gif}'],
                tasks: ['imagemin'],
                options: {
                    spawn: false,
                }
            }
        },

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['watch']);

};