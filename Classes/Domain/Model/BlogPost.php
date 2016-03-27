<?php
namespace Isan\IsanBlog\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Sebastian Antosch <s.antosch@i-san.de>, I-SAN.de Webdesign & Hosting GbR
 *           Christian Baur <c.baur@i-san.de>, I-SAN.de Webdesign & Hosting GbR
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * BlogPost
 */
class BlogPost extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * uid
     *
     * @var int
     */
    protected $uid = 0;

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * subtitle
     *
     * @var string
     */
    protected $subtitle = '';

    /**
     * abstract
     *
     * @var string
     */
    protected $abstract = '';

    /**
     * crdate
     *
     * @var int
     */
    protected $crdate = 0;

    /**
     * starttime
     *
     * @var int
     */
    protected $starttime = 0;

    /**
     * author
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Isan\IsanBlog\Domain\Model\Author>
     */
    protected $author = null;
    
    /**
     * tags
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Isan\IsanBlog\Domain\Model\Tag>
     */
    protected $tags = null;

    /**
     * categories
     *
     * @var	\TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories = null;

    /**
     * images
     *
     * @var array
     */
    protected $images = NULL;
    
    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->author = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->tags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param string $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }


    /**
     * @return string
     */
    public function getDate()
    {
        if($this->starttime) {
            return $this->starttime;
        }
        return $this->crdate;
    }

    /**
     * Adds a Author
     *
     * @param \Isan\IsanBlog\Domain\Model\Author $author
     * @return void
     */
    public function addAuthor(\Isan\IsanBlog\Domain\Model\Author $author)
    {
        $this->author->attach($author);
    }
    
    /**
     * Removes a Author
     *
     * @param \Isan\IsanBlog\Domain\Model\Author $authorToRemove The Author to be removed
     * @return void
     */
    public function removeAuthor(\Isan\IsanBlog\Domain\Model\Author $authorToRemove)
    {
        $this->author->detach($authorToRemove);
    }
    
    /**
     * Returns the author
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Isan\IsanBlog\Domain\Model\Author> $author
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    /**
     * Sets the author
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Isan\IsanBlog\Domain\Model\Author> $author
     * @return void
     */
    public function setAuthor(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $author)
    {
        $this->author = $author;
    }
    
    /**
     * Adds a Tag
     *
     * @param \Isan\IsanBlog\Domain\Model\Tag $tag
     * @return void
     */
    public function addTag(\Isan\IsanBlog\Domain\Model\Tag $tag)
    {
        $this->tags->attach($tag);
    }
    
    /**
     * Removes a Tag
     *
     * @param \Isan\IsanBlog\Domain\Model\Tag $tagToRemove The Tag to be removed
     * @return void
     */
    public function removeTag(\Isan\IsanBlog\Domain\Model\Tag $tagToRemove)
    {
        $this->tags->detach($tagToRemove);
    }
    
    /**
     * Returns the tags
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Isan\IsanBlog\Domain\Model\Tag> $tags
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * Sets the tags
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Isan\IsanBlog\Domain\Model\Tag> $tags
     * @return void
     */
    public function setTags(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Adds a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category) {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove) {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     */
    public function getCategories() {

        $categories = $this->categories->toArray();

        /*
         * Sort categories
         */
        usort($categories,function($a, $b){
            return $a->getSorting() == $b->getSorting() ? 0 : ( $a->getSorting() > $b->getSorting() ) ? 1 : -1;
        });

        return $categories;
    }

    /**
     * Sets the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     * @return void
     */
    public function	setCategories(\TYPO3\CMS\Extbase\Domain\Model\Category $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Returns the images
     *
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param array $images
     * @return void
     */
    public function setImages($images)
    {
        $this->images = $images;
    }
}