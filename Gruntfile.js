// Ensure server goes down after Grunt stops
var exec = require('child_process').exec;
process.on('SIGINT', function () {
    exec('/Applications/MAMP/bin/stop.sh', function () {
        process.exit();
    });
});

module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // TASKS

        // Start MAMP

        exec: {
          serverup: {
            command: '/Applications/MAMP/bin/start.sh'
          },
          serverdown: {
            command: '/Applications/MAMP/bin/stop.sh'
          }
        },

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
                    src: ['**/*.{png,jpg,gif,jpeg}'],
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
            sass: {
                files: ['assets/scss/**/*.scss'],
                tasks: ['compass:dist'],
            },
            css: {
                files: ['assets/css/*.css']
            },
            images: {
                files: ['assets/img/*.{png,jpg,gif,ico,jpeg}'],
                tasks: ['imagemin'],
                options: {
                    spawn: false,
                }
            },
            livereload: {
                options: {
                    livereload: true
                },
            files: [
                '**/*.php',
                'assets/css/{,*/}*.css',
                'assets/js/{,*/}*.js'
                ]
            }
        },

    });

    // 3. Where we tell Grunt we plan to use this plug-in. Use "npm i --save-dev load-grunt-tasks" to load new grunt tasks
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-compass');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['exec:serverup', 'watch', 'exec:serverdown']);

};