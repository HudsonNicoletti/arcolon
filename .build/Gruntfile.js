module.exports = function(grunt){
  grunt.initConfig({

    sass: {
      dist: {
        options: {
          style: 'compressed'   // nested, compact, compressed, expanded.
        },
        files: {
          '../public/assets/public/styles/main.css': 'styles/main.sass',
        }
      }
    },

    postcss: {
      options: {
        map: true,
        processors: [
          require('autoprefixer-core')({
            browsers: ['last 2 versions']
          })
        ]
      },
      dist: {
        src: '../public/assets/public/styles/*.css'
      }
    },

    rucksack: {
      compile: {
        files: {
          '../public/assets/public/styles/main.css': '../public/assets/public/styles/main.css'
        }
      }
    },

    uglify: {
      my_target: {
        files: {
          '../public/assets/public/scripts/functions.min.js': ['scripts/functions.js']
        }
      }
    },

    watch: {
      sass:
      {
        files: ['styles/*.sass','styles/*/*.sass'],
        tasks: ['sass','rucksack','postcss:dist'],
        options: {
          livereload: true,
        }
      },
      js:
      {
        files: ['scripts/*.js','scripts/*/*.js'],
        tasks: ['uglify'],
        options: {
          livereload: true,
        }
      },
      html:
      {
        files: ['../*.html'],
        options: {
          livereload: true,
        }
      }
    },

  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-rucksack');
  grunt.loadNpmTasks('grunt-postcss');
  grunt.registerTask('default', ['watch']);
}
