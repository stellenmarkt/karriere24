<?php
/**
 * Karriere24
 *
 * @filesource
 * @license 
 * @copyright  
 */
namespace Karriere24\Model;

use Jobs\Entity\Job;
use Zend\View\Helper\Url;
use Jobs\View\Helper\JobUrl;
use Jobs\Model\ApiJobDehydrator as OriginalApiJobDehydrator;

class ApiJobDehydrator extends OriginalApiJobDehydrator
{
    /**
     * ViewHelper for generating an url
     *
     * @var Url $url
     */
    protected $url;
  /**
   * ViewHelper for generating an url to a job posting
   *
   * @var JobUrl $jobUrl
   */
    protected $jobUrl;
	/**
	* ViewHelper for generating an url to apply
	*
	* @var ApplyUrl $applyUrl
	*/
	protected $applyUrl;
	
    /**
     * @param Url $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
   /**
    * @param JobUrl $url
    *
    * @return $this
    */
    public function setJobUrl($url)
    {
        $this->jobUrl = $url;
        return $this;
    }
	/**
    * @param ApplyUrl $url
    *
    * @return $this
    */
    public function setApplyUrl($url)
    {
        $this->applyUrl = $url;
        return $this;
    }
    /**
     * @param Job $job
     *
     * @return array
     */
    public function dehydrate(Job $job)
    {
		$workLocations=array();
		foreach ($job->getLocations() as $locationObject) {
			/* @var \Jobs\Entity\Location $locationObject */
			$workLocations[] = $locationObject->toArray();
		}
        return array(
			'id' => $job->getId(),
            'datePublishStart' => $job->getDatePublishStart(),
            'title' => $job->getTitle(),
            'location' => $job->getLocation(),
            'link' => $this->jobUrl->__invoke(
                $job,[
                  'linkOnly'=> true,
                  'absolute' => true,
                ]
            ),
			'application' => $this->applyUrl->__invoke(
				$job,[
					'linkOnly'=>true,
					'absolute' => true,
				]
			),
			'email' => $job->getContactEmail(),
			'workLocations' => $workLocations,
            'organization' => array(
				'id' => $job->getOrganization()->getId(),
                'name' => $job->getOrganization()->getOrganizationName()->getName(),
            ),
            'template_values' => array(
				'description' => $job->getTemplateValues()->getDescription(),
                'requirements' => $job->getTemplateValues()->getRequirements(),
                'qualification' => $job->getTemplateValues()->getQualifications(),
                'benefits' => $job->getTemplateValues()->getBenefits(),
				'html' => $job->getTemplateValues()->getHtml(),
            ),
			'plainText' => $job->getMetaData('plainText'),
        );
    }
    /**
     * @param Job[] $jobs
     * @return array
     */
    public function dehydrateList(array $jobs)
    {
        $result = [];
        foreach ($jobs as $job) {
            $result[] = $this->dehydrate($job);
        }
        return $result;
    }
}