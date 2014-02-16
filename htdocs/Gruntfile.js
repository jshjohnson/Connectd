module.exports = function(grunt) {

  //Load NPM tasks

  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-imageoptim');
  grunt.loadNpmTasks('grunt-svg2png');
 
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    //Minify JS

    uglify: {
      prod: {
        files: {
          'assets/js/scripts.min.js': ['assets/js/scripts.js', 'assets/js/plugins.js']
        }
      }
    },

    // Compile Sass

    compass: {
      prod: {
        options: {
          config: 'config.rb'
        }
      }
    },

    // Optimise images

    imageoptim: {
        prod: {
            src: ['assets/img'],
            options: {
                quitAfter: true
            }
        }
    },

    // Rasterise SVGs

    svg2png: {
        prod: {
            files: [
                { src: ['assets/img/**/*.svg'] }
            ]
        }
    },

    // Watch
 
    watch: {
      scripts: {
          files: ['assets/js/*.js'],
          tasks: ['uglify'],
          options: {
              spawn: false,
          },
      },

      css: {
        files: 'assets/scss/**/*.scss',
        tasks: ['compass'],
        options: {
          livereload: true
        }

      }
    }
  
  });
 
  // Build

  grunt.registerTask('default',
    [
      'svg2png:prod',
      'imageoptim:prod',
      'compass:prod',
      'uglify:prod'
    ]);
 
}