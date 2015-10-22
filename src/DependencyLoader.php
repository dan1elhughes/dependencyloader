<?php namespace xes;

class DependencyLoader
{
    private $dependencies = [];

    public function add(array $dependency)
    {
        if (!array_key_exists('local', $dependency) && !array_key_exists('cdn', $dependency)) {
            throw new \Exception('Dependency must have either local or cdn URL');
        }

        if (!array_key_exists('name', $dependency)) {
            throw new \Exception('Dependency must be named');
        }

        $name = $dependency['name'];
        unset($dependency['name']);

        $this->dependencies[$name] = $dependency;
        return $this;
    }

    public function all($rootpath, $preferLocal)
    {
     // Prefer local or cdn files, with the other as a backup
        $preferred = ($preferLocal ? 'local' : 'cdn');
        $backup = ($preferLocal ? 'cdn' : 'local');

        return array_map(function ($dependency) use ($preferred, $backup, $rootpath) {

         // Append rootpath to local URLs
            if (array_key_exists('local', $dependency)) {
                $dependency['local'] = $rootpath.$dependency['local'];
            }

         // Return the preferred URL
            if (array_key_exists($preferred, $dependency)) {
                return $dependency[$preferred];
            } else {
                return $dependency[$backup];
            }
        }, $this->dependencies);
    }

    public function getLocal($name, $preferLocal)
    {
        if (array_key_exists('name', $this->dependencies)) {
            $toReturn = $this->dependencies['name'];
        } else {
            throw new \Exception("Dependency $name not found");
        }
    }
}
