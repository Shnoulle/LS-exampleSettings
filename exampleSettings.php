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
            'help'=>'An help text',
        ),
        'checkbox'=>array(
            'type'=>'checkbox',
            'label'=>'A checkbox setting',
            'help'=>'An help text',
        ),
        'float'=>array(
            'type'=>'float',
            'label'=>'A float setting',
            'help'=>'The pattern is set to  "\d+(\.\d+)?"',
        ),
        'html'=>array(
            'type'=>'html',
            'label'=>'A html setting',
            'help'=>'Some help for HTML5 editor"',
        ),
        'int'=>array(
            'type'=>'int',
            'label'=>'A int setting',
            'help'=>'For integer value, pattern is "\d+"',
        ),
        'json'=>array(
            'type'=>'json',
            'label'=>'A json setting',
            'editorOptions'=>array('mode'=>'tree'),
            'help'=>'For json settings, here with \'editorOptions\'=>array(\'mode\'=>\'tree\'), . See jsoneditoronline.org',
        ),
        'logo'=>array(
            'type'=>'logo',
            'label'=>'The logo',
            'path'=>'assets/logo.png',
            'help'=>'Just use type and path'
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
            ),
            'help'=>'A select setting, need an array of option.',
        ),
        'string'=>array(
            'type'=>'string',
            'label'=>'A string setting',
            'help'=>'Some help.',
        ),
        'text'=>array(
            'type'=>'text',
            'label'=>'A text setting',
            'help'=>'Some help.',
        ),
        'password'=>array(
            'type'=>'password',
            'label'=>'A password setting',
            'help'=>'Some help.',
        ),
        /* functionnality list not ready */
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
    );
    
    public function __construct(PluginManager $manager, $id) {
        parent::__construct($manager, $id);
        //$this->subscribe('beforeSurveySettings');
        //$this->subscribe('newSurveySettings');
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
                    'current' => $this->get('boolean', 'Survey', $event->get('survey'))
                ),
            )
         ));
    }

    public function newSurveySettings()
    {
        $event = $this->event;
        foreach ($event->get('settings') as $name => $value)
        {
            $this->set($name, $value, 'Survey', $event->get('survey'));
        }
    }

}
