module.exports = function(grunt)
{
    // -----------------------------------------
    // Start Grunt configuration
    // -----------------------------------------

    grunt.initConfig({

        // Load package.json file
        pkg: grunt.file.readJSON('package.json'),
        sass: {
            options: {
                sourceMap: true,
                includePaths: [
                    './resources/assets/sass/foundation-sites/scss'
                ]
            },
            dist: {
                files: {
                    'public/css/main.css': 'resources/assets/sass/app.scss'
                }
            }
        }

    });


    // Load Grunt tasks
    // -----------------------------------------

    grunt.loadNpmTasks('grunt-sass');


    // -----------------------------------------
    // Register Grunt tasks
    // -----------------------------------------

    grunt.registerTask('buildCss', ['sass']);
    grunt.registerTask('default',  ['buildCss']);

}
