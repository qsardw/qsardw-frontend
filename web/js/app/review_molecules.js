/* 
 * The MIT License
 *
 * Copyright 2014 Javier Caride Ulloa <javier.caride@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

var loadNextCleanMolecule = function() {
    var currentIndex = moleculeIds.indexOf(currentMolecule);
    if (currentIndex < (totalMolecules - 1)) {
        currentIndex++;
        currentMolecule = moleculeIds[currentIndex];
        loadCleanMoleculeData();
    }
};

var loadPrevCleanMolecule = function() {
    var currentIndex = moleculeIds.indexOf(currentMolecule);
    if (currentIndex > 0) {
        currentIndex--;
        currentMolecule = moleculeIds[currentIndex];
        loadCleanMoleculeData();
    }
};

var loadNextMolecule = function() {
    var currentIndex = moleculeIds.indexOf(currentMolecule);
    if (currentIndex < (totalMolecules - 1)) {
        currentIndex++;
        currentMolecule = moleculeIds[currentIndex];
        loadMoleculeData();
    }
};

var loadPrevMolecule = function() {
    var currentIndex = moleculeIds.indexOf(currentMolecule);
    if (currentIndex > 0) {
        currentIndex--;
        currentMolecule = moleculeIds[currentIndex];
        loadMoleculeData();
    }
};

var loadCleanMoleculeData = function() {
    $.ajax({
        url: 'http://' + baseUrl + ':8080/qsardw-rest/api/molecule/' + currentMolecule,
        success: drawCleanMoleculeData
    });
};

var loadMoleculeData = function() {
    $.ajax({
        url: 'http://' + baseUrl + ':8080/qsardw-rest/api/molecule/' + currentMolecule,
        success: drawMoleculeData
    });
};

/**
 * Calls the endpoint to flag a molecule as a duplicate
 */
var flagAsDuplicateMolecule = function() {
    //showExecutingActionModal();
    $.ajax({
        url: 'http://' + baseUrl + ':8080/qsardw-rest/api/molecule/' + currentMolecule + '/setduplicate',
        success: doFlagAsDuplicateMolecule,
        type: 'PUT',
        data: {}
    });
};

/**
 * Calls the endpoint to flag a molecule as deleted
 */
var flagAsDeletedMolecule = function() {
    //showExecutingActionModal();
    $.ajax({
        url: 'http://' + baseUrl + ':8080/qsardw-rest/api/molecule/' + currentMolecule + '/setdeleted',
        success: doFlagAsDeletedMolecule,
        type: 'PUT',
        data: {}
    });
};

/**
 * Calls the endpoint to flag a molecule as deleted
 */
var flagAsCleanMolecule = function() {
    //showExecutingActionModal();
    $.ajax({
        url: 'http://' + baseUrl + ':8080/qsardw-rest/api/molecule/' + currentMolecule + '/setclean',
        success: doFlagAsCleanMolecule,
        type: 'PUT',
        data: {}
    });
};

var openViewDuplicatesPage = function() {
    $.ajax({
        url: 'http://' + baseUrl + ':8080/qsardw-rest/api/molecule/' + currentMolecule,
        success: doOpenViewDuplicatesPage
    });
};

var doOpenViewDuplicatesPage = function(data) {
    window.location = '/datasets/review/' + data.dataset +'/duplicates/' + data.inchiKey;
};

var showExecutingActionModal = function() {
    $('#doActionModal').modal('show');
};

var hideExecutingActionModal = function() {
    $('#doActionModal').modal('hide');
};

var drawCleanMoleculeData = function(data) {
    drawMoleculeData(data);
    if (data.isDuplicated === false) {
        $('#flagDuplicate').show();
        $('#viewDuplicates').hide();
    } else {
        $('#flagDuplicate').hide();
        $('#viewDuplicates').show();
    }
};

var doFlagAsDeletedMolecule = function(data) {
    doFlagMolecule(data, 4);
};

var doFlagAsDuplicateMolecule = function(data) {
    doFlagMolecule(data, 2);
};

var doFlagAsCleanMolecule = function(data) {
    doFlagMolecule(data, 1);
};

var doFlagMolecule = function(data, statusToCheck) {
    if (data.processedStatus === statusToCheck) {
        var currentIndex = moleculeIds.indexOf(currentMolecule);

        if (currentIndex === (totalMolecules -1)) {
            // Last molecule of the array load previous molecule
            var previousIndex = currentIndex - 1;
            currentMolecule = moleculeIds[previousIndex];        
        } else {
            // Load Next molecule
            var nextIndex = currentIndex + 1;
            currentMolecule = moleculeIds[nextIndex];
        }

        moleculeIds.splice(currentIndex, 1);
        totalMolecules = moleculeIds.length;

        loadCleanMoleculeData();
        
        //hideExecutingActionModal();
    }
}; 

var drawMoleculeData = function(data) {
    var currentIndex = moleculeIds.indexOf(currentMolecule) + 1;

    $('#molinfoSmile').html(data.smile);
    $('#molinfoInchi').html(data.inchi);
    $('#molinfoInchiKey').html(data.inchiKey);
    $('#molinfoSourceId').html(data.sourceId);
    $('#molinfoSourceName').html(data.sourceName);
    $('#molinfoSourcePublication').html(data.sourcePublication);
    $('#currentMoleculeIdx').html('Reviewing ' + currentIndex + ' of ' + totalMolecules);
    
    var imageSrc = '/data/images/'+ data.dataset + '/molecule_'+ data.id +'.png';
    $('#molinfoImage').attr('src',imageSrc);
};



