module.exports = function(grunt) {

    // var appConfig = grunt.file.readJSON( 'app-config.json' ) || {};

    var baseDir = "";
    var source = baseDir + "source/";
    var assets = baseDir + "assets/";

    var version = '1.0';

    var javascript = {
        libraries: [],
        theme: [
            source + "js/libraries/*.js",

            //Global Files
            source + "js/global/*.js",

            //Page Specific Files
            source + "js/pages/*.js",

            //Main is last, and should initialize the site
            source + "js/main.js"
        ],
        all: []
    };

    Array.prototype.push.apply(javascript.all,javascript.libraries);
    Array.prototype.push.apply(javascript.all,javascript.theme);

    grunt.initConfig({

            pkg: grunt.file.readJSON('package.json'),
            
            jshint: {
                all: {
                    src: javascript.theme,
                    options: {
                        bitwise: false,
                        camelcase: false,
                        curly: false,
                        eqeqeq: false,
                        forin: true,
                        immed: false,
                        indent: 4,
                        latedef: false,
                        newcap: false,
                        noarg: true,
                        noempty: true,
                        nonew: true,
                        regexp: true,
                        undef: false,
                        unused: false,
                        trailing: true,
                        asi: true,
                        eqnull: true,
                        expr: true,
                    },
                }
            },

            concat: {
                js: {
                    src: javascript.all,
                    dest: assets + "js/scripts.js",
                }

                /*
                options: {
                    process: function(src, filepath) {
                            return '\n\n// file: ' + filepath + '\n\n' + src + ';';
                        }
                },
                dist: {
                    src: javascript.all,
                    dest: assets + "scripts.js",
                },
                */
            },

            uglify: {
                options: {
                    mangle: false,
                    preserveComments: 'some'
                },
                my_target: {
                    files: (function() {
                        var files = {};
                        files[assets + "js/scripts.min.js"] = [assets + "js/scripts.js"];
                        return files;
                    })()
                }
            },

            less: {
                development: {
                    files: (function() {
                        var files = {};
                        files["style.css"] = source + "less/main.less";
                        files[assets + "css/dev.css"] = source + "less/dev.less";
                        return files;
                    })()
                },
                production: {
                    options: {
                        compress: true,
                        yuicompress: true,
                        optimization: 2
                    },
                    files: (function() {
                        var files = {};
                        files["style.css"] = source + "less/main.less";
                        return files;
                    })()
                }
            },

            usebanner: {

                options: {
                  position: 'top',
                  banner: '/*\nTheme Name: AMeyerson Theme\n' +
                            'Version: ' + version + '\n*/' + 
                            '\n//complined: <%= grunt.template.today("dd-mm-yyyy") %>',
                  linebreak: true
                },
                files: {
                  src: [ assets + "dev.css", "style.css" ]
                }

            },

            csslint: {
                lax: {
                    options: {
                        "important": false,
                        "adjoining-classes": false,
                        "box-sizing": false,
                        "order-alphabetical" : false,
                        quiet: true
                    },
                    src: assets + "css/dev.css"
                },

                strict: {
                    options: {
                        "order-alphabetical" : false,
                        // "adjoining-classes": false,
                        // "box-sizing": false,
                        quiet: false
                    },
                    src: assets + "dev.css"
                }
            },

            watch: {
                styles: {
                    files: [source + 'less/**/*.less'], // which files to watch
                    tasks: ['less', 'usebanner'], 
                    options: {
                        nospawn: true
                    }
                },
                js: {
                    files: [source + 'js/**/*.js'],
                    tasks: ['jshint', 'concat', 'uglify']
                }

            }
        });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-csslint');
    grunt.loadNpmTasks('grunt-banner');

    grunt.registerTask('default', ['less:development', 'usebanner', 'concat']);
    grunt.registerTask('deploy', ['less:production', 'usebanner', 'jshint', 'concat', 'uglify']);
};