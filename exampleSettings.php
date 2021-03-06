<?php
/**
 * exampleSettings Plugin for LimeSurvey
 * purpose is to show all available settings and some trick
 *
 * @author Denis Chenu <denis@sondages.pro>
 * @copyright 2013 Denis Chenu <http://sondages.pro>
 * @license GPL v3
 * @version 1.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * logo.png <http://thenounproject.com/term/lime/9260/> from Maya Irvine <mayairvine.com> in Public Domain
 */
class exampleSettings extends PluginBase {

    protected $storage = 'DbStorage';
    static protected $name = 'Example of settings';
    static protected $description = 'Example plugin showing all settings';
    
    protected $settings = array(
        'boolean'=>array(
            'type'=>'boolean',
            'label'=>'A boolean setting',
            'help'=>'An help text, default is null, here set to 0.',
            'default'=>0,
        ),
        'checkbox'=>array(
            'type'=>'checkbox',
            'label'=>'A checkbox setting',
            'help'=>'An help text, if not checkd set to NULL, NULL is the default',
        ),
        'float'=>array(
            'type'=>'float',
            'label'=>'A float setting',
            'help'=>'The pattern is set to  "\d+(\.\d+)?". Default set to 42.42.',
            'default'=>42.42,
        ),
        'html'=>array(
            'type'=>'html',
            'label'=>'A html setting',
            'help'=>'Some help for HTML5 editor, accept &lt;b&gt; &lt;i&gt; but not &lt;strong&gt; or &lt;em&gt;',
            'default'=>'Some html with <b>bold</b> or <i>italic</i> text.',
        ),
        'int'=>array(
            'type'=>'int',
            'label'=>'A int setting',
            'help'=>'For integer value, pattern is "\d+"',
            'default'=>'42',
        ),
        'json'=>array(
            'type'=>'json',
            'label'=>'A json setting',
            'editorOptions'=>array('mode'=>'tree'),
            'help'=>'For json settings, here with \'editorOptions\'=>array(\'mode\'=>\'tree\'), . See jsoneditoronline.org',
            'default'=>'{"array":[1,2,3],"boolean":true,"null":null,"number":123,"object":{"a":"b","c":"d","e":"f"},"string":"Hello World"}',
        ),
        'logo'=>array(
            'type'=>'logo',
            'label'=>'The logo',
            'path'=>'assets/logo.png',
            'help'=>'Just use type and path : after another logo without label and help.'
        ),
        'logo2'=>array(
            'type'=>'logo',
            'path'=>'assets/logo.png',
        ),
        'info' => array(
            'type' => 'info',
            'content' => 'Some information to show to admin. You can use html code like <strong>strong</strong> or more with bootstrap for example.<p class="alert">For your information : you see 2 logo before this setting, but the 2 logo are different in version 2.06 of LimeSurvey.</p>',
        ),
        'relevance'=>array(
            'type'=>'relevance',
            'label'=>'A relevance setting',
            'help'=>'A relevance setting',
        ),
        'select'=>array(
            'type'=>'select',
            'label'=>'A select setting',
            'options'=>array(
                'opt1'=>'Option 1',
                'opt2'=>'Option 2',
                'opt3'=>'Option 3 (default)',
            ),
            'help'=>'A select setting, need an array of option.',
            'default'=>'opt3',
        ),
        'string'=>array(
            'type'=>'string',
            'label'=>'A string setting',
            'help'=>'Some help.',
            'default'=>'Default string',
        ),
        'text'=>array(
            'type'=>'text',
            'label'=>'A text setting',
            'help'=>'Some help.',
            'default'=>"Some default text\n use \\n for multiline",
        ),
        'password'=>array(
            'type'=>'password',
            'label'=>'A password setting',
            'help'=>'Some help.',
            'default'=>'default password',
        ),
        /* functionnality list not ready (or don't understand)*/
        /*
        'settingslist'=>array(
            'type'=>'list',
            'label'=>'A list setting: need a list of settings',
            'help'=>'Some help for the list, each items can have an help, but shown inside the table.',
            'items'=>array(
                'string-lst'=>array(
                    'type'=>'string',
                    'label'=>'A string setting in list',
                ),
                'checkbox-lst'=>array(
                    'type'=>'checkbox',
                    'label'=>'A checkbox setting in list',
                ),
            ),
        ),
        */
    );
    
    public function __construct(PluginManager $manager, $id) {
        parent::__construct($manager, $id);
        $this->subscribe('beforeSurveySettings');
        $this->subscribe('newSurveySettings');
    }

    /**
     * This event is fired by the administration panel to gather extra settings
     * available for a survey.
     * The plugin should return setting meta data.
     * @param PluginEvent $event
     */
    public function beforeSurveySettings()
    {
        $event = $this->event;
        $event->set("surveysettings.{$this->id}", array(
            'name' => get_class($this),
            'settings' => array(
                'boolean'=>array(
                    'type'=>'boolean',
                    'label'=>'A boolean setting',
                    'help'=>'An help text',
                    'current' => $this->get('boolean', 'Survey', $event->get('survey'),$this->get('boolean',null,null,$this->settings['boolean']['default'])),
                ),
                'checkbox'=>array(
                    'type'=>'checkbox',
                    'label'=>'A checkbox setting',
                    'help'=>'An help text',
                    'current' => $this->get('checkbox', 'Survey', $event->get('survey'),$this->get('checkbox'))
                ),
                'float'=>array(
                    'type'=>'float',
                    'label'=>'A float setting',
                    'help'=>'The pattern is set to  "\d+(\.\d+)?"',
                    'current' => $this->get('float', 'Survey', $event->get('survey'),$this->get('float',null,null,$this->settings['float']['default'])),
                ),
                'html'=>array(
                    'type'=>'html',
                    'label'=>'A html setting',
                    'help'=>'Some help for HTML5 editor"',
                    'current' => $this->get('html', 'Survey', $event->get('survey'),$this->get('html',null,null,$this->settings['html']['default'])),
                ),
                'int'=>array(
                    'type'=>'int',
                    'label'=>'A int setting',
                    'help'=>'For integer value, pattern is "\d+"',
                    'current' => $this->get('int', 'Survey', $event->get('survey'),$this->get('int',null,null,$this->settings['int']['default'])),
                ),
                'json'=>array(
                    'type'=>'json',
                    'label'=>'A json setting',
                    'editorOptions'=>array('mode'=>'tree'),
                    'help'=>'For json settings, here with \'editorOptions\'=>array(\'mode\'=>\'tree\'), . See jsoneditoronline.org',
                    'current' => $this->get('json', 'Survey', $event->get('survey'),$this->get('json',null,null,$this->settings['json']['default'])),
                ),
                'logo'=>array(
                    'type'=>'logo',
                    'label'=> 'A logo with a label',
                    'path'=>Yii::app()->baseUrl."/plugins/exampleSettings/assets/logo.png",
                ),
                'info' => array(
                    'type' => 'info',
                    'content' => 'Some information to show to admin. You can use html code like <strong>strong</strong> or more with bootstrap for example',
                ),
                'relevance'=>array(
                    'type'=>'relevance',
                    'label'=>'A relevance setting',
                    'help'=>'A relevance setting',
                    'current' => $this->get('relevance', 'Survey', $event->get('survey'),$this->get('relevance')),
                ),
                'select'=>array(
                    'type'=>'select',
                    'label'=>'A select setting',
                    'options'=>array(
                        'opt1'=>'Option 1',
                        'opt2'=>'Option 2',
                        'opt3'=>'Option 3 (default)',
                    ),
                    'help'=>'A select setting, need an array of option.',
                    'current' => $this->get('select', 'Survey', $event->get('survey'),$this->get('select',null,null,$this->settings['select']['default'])),
                ),
                'string'=>array(
                    'type'=>'string',
                    'label'=>'A string setting',
                    'help'=>'Some help.',
                    'current' => $this->get('string', 'Survey', $event->get('survey'),$this->get('string',null,null,$this->settings['string']['default'])),
                ),
                'text'=>array(
                    'type'=>'text',
                    'label'=>'A text setting',
                    'help'=>'Some help.',
                    'current' => $this->get('text', 'Survey', $event->get('survey'),$this->get('text',null,null,$this->settings['text']['default'])),
                ),
                'password'=>array(
                    'type'=>'password',
                    'label'=>'A password setting',
                    'help'=>'Some help.',
                    'current' => $this->get('password', 'Survey', $event->get('survey'),$this->get('password',null,null,$this->settings['password']['default'])),
                ),
            )
         ));
    }

    public function newSurveySettings()
    {
        $event = $this->event;
        foreach ($event->get('settings') as $name => $value)
        {
            /* In order use survey setting, if not set, use global, if not set use default */
            $default=$event->get($name,null,null,isset($this->settings[$name]['default'])?$this->settings[$name]['default']:NULL);
            $this->set($name, $value, 'Survey', $event->get('survey'),$default);
        }
    }

}
