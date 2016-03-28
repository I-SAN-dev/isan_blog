<?php
namespace Isan\IsanBlog\Controller;

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
 * BlogPostController
 */
class BlogPostController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * blogPostRepository
     *
     * @var \Isan\IsanBlog\Domain\Repository\BlogPostRepository
     * @inject
     */
    protected $blogPostRepository = NULL;
    
    /**
     * action list
     *
     * @param \Isan\IsanBlog\Domain\Model\Author $author
     * @param \Isan\IsanBlog\Domain\Model\Tag $tag
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $cat
     * @return void
     */
    public function listAction(\Isan\IsanBlog\Domain\Model\Author $author = NULL, \Isan\IsanBlog\Domain\Model\Tag $tag = NULL, \TYPO3\CMS\Extbase\Domain\Model\Category $cat = NULL)
    {
        $this->view->assign('byAuthor', $author);
        $this->view->assign('byTag', $tag);
        $this->view->assign('byCategory', $cat);

        $blogPosts = $this->blogPostRepository->findAllFiltered($author, $tag, $cat);
        $this->view->assign('blogPosts', $blogPosts);
    }
}