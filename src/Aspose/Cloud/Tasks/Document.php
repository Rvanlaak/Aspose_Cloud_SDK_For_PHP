<?php
/**
 * Deals with project document level aspects.
 */
namespace Aspose\Cloud\Tasks;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;
use Aspose\Cloud\Storage\Folder;

class Document
{

    protected $fileName = '';

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Get document properties of a project file.
     *
     * @return array Returns the document properties.
     * @throws Exception
     */
    public function getProperties()
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/documentProperties';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->Properties->List;
        else
            return false;
    }

    /**
     * Get project task items. Each task item has a link to get full task representation in the project.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function getTasks()
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/tasks';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->Tasks->TaskItem;
        else
            return false;
    }

    /**
     * Get task information.
     *
     * @param integer $taskId The id of the task.
     *
     * @return array Returns the task.
     * @throws Exception
     */
    public function getTask($taskId)
    {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($taskId == '')
            throw new Exception('Task ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/tasks/' . $taskId;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->Task;
        else
            return false;
    }

    /**
     * Add a new task to a project.
     *
     * @param string $taskName The name of the new task.
     * @param integer $beforeTaskId The id of the task to insert the new task before.
     * @param string $changedFileName The name of the project document to save changes to. If this parameter is omitted then the changes will be saved to the source project document.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function addTask($taskName, $beforeTaskId, $changedFileName)
    {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($taskName == '')
            throw new Exception('Task Name not specified');

        if ($beforeTaskId == '')
            throw new Exception('Before Task ID not specified');

        //build URI 
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/tasks?taskName=' . $taskName . '&beforeTaskId=' . $beforeTaskId;
        if ($changedFileName != '') {
            $strURI .= '&fileName=' . $changedFileName;
            $this->fileName = $changedFileName;
        }

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Delete a project task with all references to it and rebuilds tasks tree.
     *
     * @param integer $taskId The id of the task.
     * @param string $changedFileName The name of the project document to save changes to. If this parameter is omitted then the changes will be saved to the source project document.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function deleteTask($taskId, $changedFileName)
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($taskId == '')
            throw new Exception('Task ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/tasks/' . $taskId;
        if ($changedFileName != '') {
            $strURI .= '?fileName=' . $changedFileName;
            $this->fileName = $changedFileName;
        }

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Get project task links.
     *
     * @return array Returns the task links.
     * @throws Exception
     */
    public function getLinks()
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/taskLinks';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->TaskLinks;
        else
            return false;
    }

    /**
     * Delete a task link.
     *
     * @param integer $index The index of the task link.
     * @param string $changedFileName The name of the project document to save changes to. If this parameter is omitted then the changes will be saved to the source project document.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function deleteLink($index, $changedFileName)
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($index == '')
            throw new Exception('Index not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/taskLinks/' . $index;
        if ($changedFileName != '') {
            $strURI .= '?fileName=' . $changedFileName;
            $this->fileName = $changedFileName;
        }

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Get project outline code items. Each outline code item has a link to get full outline code
     * definition representation in the project.
     *
     * @return array Returns the outline codes.
     * @throws Exception
     */
    public function getOutlineCodes()
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/outlineCodes';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->OutlineCodes;
        else
            return false;
    }

    /**
     * Get Outline Code
     *
     * @param integer $outlineCodeId The id of the outline code.
     *
     * @return array Returns the outline code.
     * @throws Exception
     */
    public function getOutlineCode($outlineCodeId)
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($outlineCodeId == '')
            throw new Exception('Outline Code ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/outlineCodes/' . $outlineCodeId;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->OutlineCode;
        else
            return false;
    }

    /**
     * Delete a project outline code.
     *
     * @param integer $outlineCodeId The id of the outline code.
     * @param string $changedFileName The name of the project document to save changes to. If this parameter is omitted then the changes will be saved to the source project document.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function deleteOutlineCode($outlineCodeId, $changedFileName)
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($outlineCodeId == '')
            throw new Exception('Outline Code ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/outlineCodes/' . $outlineCodeId;
        if ($changedFileName != '') {
            $strURI .= '?fileName=' . $changedFileName;
            $this->fileName = $changedFileName;
        }

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Get project extended attribute items. Each extended attribute item has a link to get full
     * extended attribute representation in the project.
     *
     * @return array Returns the file path.
     * @throws Exception
     */
    public function getExtendedAttributes()
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/extendedAttributes';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->ExtendedAttributes;
        else
            return false;
    }

    /**
     * Get project extended attribute definition.
     *
     * @param integer $extendedAttributeId
     *
     * @return array Returns the extended attribute.
     * @throws Exception
     */
    public function getExtendedAttribute($extendedAttributeId)
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($extendedAttributeId == '')
            throw new Exception('Extended Attribute ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/extendedAttributes/' . $extendedAttributeId;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->ExtendedAttribute;
        else
            return false;
    }

    /**
     * Delete a project extended attribute.
     *
     * @param integer $extendedAttributeId The id of the extended attribute.
     * @param string $changedFileName The name of the project document to save changes to. If this parameter is omitted then the changes will be saved to the source project document.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function deleteExtendedAttribute($extendedAttributeId, $changedFileName)
    {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($extendedAttributeId == '')
            throw new Exception('Extended Attribute ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/extendedAttributes/' . $extendedAttributeId;
        if ($changedFileName != '') {
            $strURI .= '?fileName=' . $changedFileName;
            $this->fileName = $changedFileName;
        }

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

}